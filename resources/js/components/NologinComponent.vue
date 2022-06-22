<template>
    <section>
        <div class="c-title c-title__form">一括フォロー</div>

        <article class="p-main__service">
            <!--ツイッター認証していない場合はDBからランダムに取得したsampleusersを並べる。-->
            <div class="p-twiiter__container">
                <div v-for="(sampleuser,index) in sampleusers" v-bind:key="index" class="c-card__twitter">
                    <div class="c-card__twitter--header">
                        <img :src="sampleuser.profile_image" alt="">
                        <h4><a :href="'https://twitter.com/' + sampleuser.screen_name" target="_blank">{{
                                sampleuser.name
                            }}</a></h4>
                    </div>
                    <p>{{ sampleuser.description }}</p><br>
                    <p><br>フォロー数：{{ sampleuser.friends_count }} フォロワー数：{{ sampleuser.followers_count }}</p>
                </div>
            </div>
        </article>
    </section>
</template>


<script>
import axios from 'axios';

export default {
    props: [
        'autofollowsample_ajax', //viewから受け渡されたURL：autofollow/sampleindex
    ],
    data: function () {
        return {
            el: '#js-nologin',
            sampleusers: [],
        }
    },
    mounted() {
        let self = this;
        let url = this.autofollowsample_ajax; //axiosでajaxデータを取得する。
        axios.get(url).then(function (response) {
            self.sampleusers = response.data;
        });
    }
}
</script>
