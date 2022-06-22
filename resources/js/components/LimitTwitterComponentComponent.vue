<template>
    <section>
        <div class="c-title c-title__form">一括フォロー</div>

        <div>
            <article class="p-main__service">
                <div class="p-autofollow__container">
                    <div class="p-autofollow__description">
                        <p>一括フォローをONにすると15分に一度、自動フォローを実施します。</p>
                        <div class="p-autofollow__ongoing" v-show="ongoing">
                            <p>当日のフォロー上限に達しているため翌日以降に自動フォローを実施します。</p>
                        </div>
                        <!--自動フォローのボタン。クリックするたびにautofollowStartをon/off切り替える-->
                        <button class="c-button c-button__autofollow" v-on:click="autofollowStart"
                                v-bind:class='{nowfollow:ongoing}' v-if="auto_status === '1'">
                            一括フォローOFFにする
                        </button>
                        <button class="c-button c-button__autofollow" v-on:click="autofollowStart"
                                v-bind:class='{nowfollow:ongoing}' v-else>
                            一括フォローONにする
                        </button>
                    </div>
                </div>

                <!--アカウント情報一覧。usersからforで表示。-->
                <div class="p-twiiter__container">
                    <h2>仮想通貨アカウント一覧</h2>
                    <div v-for="(user,index) in users" v-bind:key="index" class="c-card__twitter">
                        <div class="c-card__twitter--header">
                            <img :src="user.profile_image_url" alt="">
                            <h4><a :href="'https://twitter.com/' + user.screen_name" target="_blank">{{ user.name }}</a>
                            </h4>
                        </div>
                        <button>@{{ user.screen_name }}</button>
                        <p>{{ user.description }}</p><br>
                        <p>《最新ツイート》<br>
                            {{ typeof user.status !== 'undefined' ? user.status.text : 'ツイートがありません' }}</p><br>
                        フォロー数：{{ user.friends_count }} フォロワー数：{{ user.followers_count }}<br>
                    </div>
                </div>
            </article>
        </div>
    </section>
</template>


<script>
import axios from 'axios';

export default {
    props: [
        'users_results', //利用中のユーザーがフォローしていないアカウントの情報。Twitter認証していればこの情報を出します。
        'follow_users', //ランダムにDBから取得したユーザー情報
        'autofollow_ajax',//個別フォローするurlへのポストの時のurl
        'autofollowall_ajax',//url情報。autofollow/allです。
        'autofollow_check' //db上から取得したautofollowの状態。1ならばtrue、つまり自動フォロー中。
    ],
    data: function () {
        return {
            el: '#twitter',
            reset_ok: true,
            ongoing: "", //自動フォローを実施している状態。trueであれば自動フォローON。
            users: this.users_results, //users_resultsをusersに詰め込んでおく。
            auto_status: this.autofollow_check
        }
    },
    mounted() {
        //mountedでページアクセス時に自動フォローを実施しているか判定。1なら自動フォロー中で、ongoingをtrue。
        //ongoingがtrueの場合、「自動フォロー実施中です」という表示が出る。
        if (this.autofollow_check === '1') {
            this.ongoing = true;
            this.auto_status = this.autofollow_check
        } else {
            this.ongoing = false;
            this.auto_status = this.autofollow_check
        }
    },
    methods: {
        //自動フォローを切り替えた際にボタンの表示、「自動フォロー実施中です」の表示非表示を切り替えるメソッド
        checkOngoing: function () {
            if (this.autofollow_check === '1' || true) {
                this.ongoing = true;
            } else {
                this.ongoing = false;
            }
        },
        //一括フォロー（自動フォローのONOFFを切り替えるメソッド）
        autofollowStart: function () {
            let self = this;
            let url = this.autofollowall_ajax; //ajax先のurl
            let auto_status = this.auto_status;

            //今現在のDB上のautofollowの状態が1の場合オートフォローの状態を0にする
            if (self.auto_status === '1') {
                this.ongoing = true;
                self.auto_status = 0;
            } else {
                this.ongoing = false;
                self.auto_status = 1; //今現在のフォローの状態が1ではない場合、フォローの状態を1にする
            }
            let request = self.auto_status;
            axios.post(url, {
                request
            }).then((res) => {
                alert('一括フォローの設定を切り替えました。ページを再読み込みします。');
                location.reload();
            }).catch(error => {
            });
        }
    },
    computed: {
        //個別フォローをした際にfollowingがfalseのユーザーを表示から削除する算出プロパティ
        nofollow: function () {
            return this.users.filter(function (user) {
                return user.following === false;
            });
        }
    }
}
</script>
