<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashionably Late</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <h1>FashionablyLate</h1>
            </div>
            @if (Auth::check())
            <form class="form" action="/logout" method="post">
                @csrf
                <button class="header-nav__button">logout</button>
            </form>
            @endif
        </div>
    </header>

    <main>
        <div class="admin-form__content">
            <div class="admin-form__heading">
                <h2 class="admin-form__title">Admin</h2>
            </div>
        </div>
        <div class="admin__content">
            <form class="search-form" action="/admin/search" method="get">
                @csrf
                <div class="search-form__group">
                    <div class="search-form__item">
                        <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" size="35" />
                        <select class="search-form__item-select" name="gender">
                            <option value="">性別</option>
                            <option value="male">男性</option>
                            <option value="female">女性</option>
                            <option value="other">その他</option>
                        </select>
                        <select class="search-form__item-select" name="category_id">
                            <option value="">お問い合わせの種類</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->content }}</option>
                            @endforeach
                        </select>
                        <label>
                            年/月/日:
                            <input class="search-form__item-input" type="date" name="date" />
                        </label>
                    </div>
                    <div class="search-form__button">
                        <button class="search-form__button-submit" type="submit">検索</button>
                    </div>
                    <div class="search-form__button">
                        <button class="search-form__reset-button" type="reset">リセット</button>
                    </div>
                </div>
            </form>
            <form class="search-form__export" action="{{ route('export-user') }}" method="get">
                @csrf
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                <div class="search-result__toolbar">
                    <button class="search-form__export-button" type="submit">エクスポート</button>
                </div>
            </form>
            <div class="search-result__pagination-top">
               {{ $contacts->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
            <div class="user-table">
                <table class="user-table__inner">
                    <tr class="user-table__row">
                        <th class="user-table__header">お名前</th>
                        <th class="user-table__header">性別</th>
                        <th class="user-table__header">メールアドレス</th>
                        <th class="user-table__header">お問い合わせの種類</th>
                        <th class="user-table__header"></th>
                    </tr>
                    @forelse($contacts as $contact)
                    <tr class="user-table__row">
                        <td class="user-table__text">
                            {{ $contact['last_name'] }} {{ $contact['first_name'] }}
                        </td>
                        <td class="user-table__text">
                            {{ $contact['gender'] === 'male' ? '男性' : ($contact['gender'] === 'female' ? '女性' : 'その他') }}
                        </td>
                        <td class="user-table__text">
                            {{ $contact['email']}}
                        </td>
                        <td class="user-table__text">
                            {{ $contact->category->content }}
                        </td>
                        <td>
                            <button class="detail-button"
                                data-contact-id="{{ $contact->id  }}"
                                data-name="{{ $contact->last_name }} {{ $contact->first_name }}"
                                data-gender="{{ $contact->gender }}"
                                data-email="{{ $contact->email }}"
                                data-tel="{{ $contact->tel }}"
                                data-address="{{ $contact->address }}"
                                data-building="{{ $contact->building }}"
                                data-content="{{ $contact->category->content }}"
                                data-detail="{{ $contact->detail }}">
                                詳細
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="user-table__text">データがありません</td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>

        <div id="detailModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <table class="detail-table">
                    <tr><th>お名前</th><td id="modal-name"></td></tr>
                    <tr><th>性別</th><td id="modal-gender"></td></tr>
                    <tr><th>メールアドレス</th><td id="modal-email"></td></tr>
                    <tr><th>電話番号</th><td id="modal-tel"></td></tr>
                    <tr><th>住所</th><td id="modal-address"></td></tr>
                    <tr><th>建物名</th><td id="modal-building"></td></tr>
                    <tr><th>お問い合わせの種類</th><td id="modal-content"></td></tr>
                    <tr><th>お問い合わせ内容</th><td id="modal-detail"></td></tr>
                </table>

                <form id="deleteForm" action="/admin/delete" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="contact_id" id="delete-contact-id">
                    <div class="modal-delete-button-container">
                        <button class="modal-delete-button" type="submit">削除</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('detailModal');
                const closeBtn = document.querySelector('.close-button');

                document.querySelectorAll('.detail-button').forEach(button => {
                    button.addEventListener('click', function () {
                    console.log(this.dataset);
                        document.getElementById('modal-name').textContent = this.dataset.name;
                        document.getElementById('modal-gender').textContent =
                            this.dataset.gender === 'male' ? '男性' :
                            this.dataset.gender === 'female' ? '女性' : 'その他';
                        document.getElementById('modal-email').textContent = this.dataset.email;
                        document.getElementById('modal-tel').textContent = this.dataset.tel;
                        document.getElementById('modal-address').textContent = this.dataset.address;
                        document.getElementById('modal-building').textContent = this.dataset.building;
                        document.getElementById('modal-content').textContent = this.dataset.content;
                        document.getElementById('modal-detail').textContent = this.dataset.detail;
                        document.getElementById('delete-contact-id').value = this.dataset.contactId;
                        modal.style.display = 'block';
                    });
                });

                closeBtn.addEventListener('click', () => modal.style.display = 'none');
                window.addEventListener('click', e => {
                    if (e.target === modal) modal.style.display = 'none';
                });
            });
        </script>
    </main>
</body>

</html>