<template>
    <div>
        <article class="p-main">
            <div class="p-form">
                <div class="c-title c-title__form">マイページ</div>

                <div class="c-form">
                    <form method="POST">
                        <input type="hidden" name="_token" v-bind:value="csrf">
                        <div>
                            <label for="name"> ニックネーム </label>
                            <div>
                                <input id="name" type="text"
                                       class="c-form__input form-control"
                                       name="name" v-model="name" required
                                       autofocus>
                            </div>
                        </div>
                        <div>
                            <label for="email">Emailアドレス </label>
                            <div>
                                <input id="email" type="text"
                                       class="c-form__input form-control "
                                       name="email" v-model="email" required
                                       autofocus>
                            </div>
                        </div>

                        <div class="c-button__wrap">
                            <div class="c-button c-button__form" @click="updateForm">
                                <div>
                                    <button type="submit" formaction="/profile/edit">
                                        更新する
                                    </button>
                                </div>
                            </div>
                            <div class="c-button c-button__form">
                                <div>
                                    <button type="submit" formaction="/profile/withdraw" @click="deleteForm">
                                        退会する
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div v-if="errors.length">
                        <h1>以下のエラーを修正してください。</h1>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </article>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        csrf: {
            type: String,
            required: true,
        }
    },
    mounted() {
        this.$nextTick(function () {
            axios.get('/home/json/name').then(response => {
                this.name = response.data;
                this.confirmName = response.data;
            })
            axios.get('/home/json/email').then(response => {
                this.email = response.data;
                this.confirmEmail = response.data;

            })
        })
    },
    methods: {
        updateForm: function (e) {
            this.errors = [];

            let email = this.email;
            if (!email.match(/.+@.+\..+/)) {
                this.errors.push('Emailの形式で入力してください');
                e.preventDefault();
                return false;
            }

            if (this.name && this.email) {
                if (!window.confirm('本当に更新しますか？')) {
                    window.alert('キャンセルされました');
                    e.preventDefault();
                    return false;
                }
                return true;
            }

            if (!this.name || !this.email) {
                this.errors.push('全て入力必須項目です');
            }
            e.preventDefault();
        },
        deleteForm: function (e) {
            this.errors = [];

            if (this.name === this.confirmName && this.email === this.confirmEmail) {
                if (!window.confirm('本当に退会しますか？')) {
                    window.alert('キャンセルされました');
                    e.preventDefault();
                    return false;
                }
                return true;
            }

            this.errors.push('登録情報と一致させてください');

            if (!this.name || !this.email) {
                this.errors.push('全て入力必須項目です');
            }
            e.preventDefault();
        },
        inputForm: function (e) {
            this.email = this.target.value;
        }
    },
    data: function () {
        return {
            name: [],
            email: [],
            errors: [],
            confirmName: [],
            confirmEmail: []
        }
    }
}
</script>
