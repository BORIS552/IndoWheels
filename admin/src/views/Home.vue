<template>
  <div class="_home">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <main class="_main">
      <div class="_grid">
        <div class="_row">
          <div v-for="(item, index) in menu" :key="index" class="_col _s4 _h3">
            <router-link :to="item.route" class="_card">
              <img :src="item.icon" alt="" class="_card__img">
              <h2 class="_card__title">{{ item.title }}</h2>
              <h3 class="_card__info">{{ item.info }}</h3>
            </router-link>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import lang from '@/lang/en';

const items = [
  {
    title: lang.menu.outlets.title,
    icon: 'images/outlets.svg',
    route: { name: 'outlets' },
    info: lang.menu.outlets.info,
  },
  {
    title: lang.menu.lotteries.title,
    icon: 'images/lotteries.svg',
    route: { name: 'lotteries' },
    info: lang.menu.lotteries.info,
  },
  {
    title: lang.menu.users.title,
    icon: 'images/users.svg',
    route: { name: 'users' },
    info: lang.menu.users.info,
  },
  {
    title: lang.menu.reviews.title,
    icon: 'images/reviews.svg',
    route: { name: 'reviews' },
    info: lang.menu.reviews.info,
  },
  {
    title: lang.menu.banners.title,
    icon: 'images/banners.svg',
    route: { name: 'banners' },
    info: lang.menu.banners.info,
  },
  {
    title: lang.menu.ads.title,
    icon: 'images/ad.svg',
    route: { name: 'ads' },
    info: lang.menu.ads.info,
  },
  {
    title: lang.menu.profile.title,
    icon: 'images/profile.svg',
    route: { name: 'profile' },
    info: lang.menu.profile.info,
  },
  {
    title: 'Customer Selfie',
    icon: 'images/share.png',
    route: { name: 'upload'},
    info: 'Upload customer selfie'
  },
  {
    title: lang.menu.logout.title,
    icon: 'images/logout.svg',
    route: { name: 'logout' },
    info: lang.menu.logout.info,
  },
];

@Component({
  components: {
    Header,
    Sidebar,
  },
})
export default class Home extends Vue {
  private title: string = lang.home.name;
  private menu: object[] = items;
}
</script>
