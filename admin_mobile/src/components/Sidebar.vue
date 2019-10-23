<template>
  <aside class="_sidebar">
    <!-- <Logo /> -->
    <ul class="_menu">
      <li v-for="(item, index) in items" ::key="index" class="_menu__item">
        <router-link :to="item.route" class="_menu__link">
          <img :src="item.icon" alt="" class="_menu__item__icon">
          <span class="_menu__item__title">{{ item.title }}</span>
          <span class="_menu__item__info">{{ item.info }}</span>
        </router-link>
      </li>
    </ul>
  </aside>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import Logo from '@/components/Logo.vue';
import lang from '@/lang/en';

const items = [
  {
    title: lang.home.name,
    icon: '/images/home.svg',
    route: { name: 'home' },
    info: lang.menu.profile.info,
  },
  {
    title: lang.menu.outlets.title,
    icon: '/images/outlets.svg',
    route: { name: 'outlets' },
    info: lang.menu.outlets.info,
  },
  {
    title: lang.menu.lotteries.title,
    icon: '/images/lotteries.svg',
    route: { name: 'lotteries' },
    info: lang.menu.lotteries.info,
  },
  {
    title: lang.menu.prizes.title,
    icon: '/images/winner.svg',
    route: { name: 'prizes' },
    info: lang.menu.prizes.info,
  },
  {
    title: lang.menu.users.title,
    icon: '/images/users.svg',
    route: { name: 'users' },
    info: lang.menu.users.info,
  },
  {
    title: lang.menu.reviews.title,
    icon: '/images/reviews.svg',
    route: { name: 'reviews' },
    info: lang.menu.reviews.info,
  },
  {
    title: lang.menu.banners.title,
    icon: '/images/banners.svg',
    route: { name: 'banners' },
    info: lang.menu.banners.info,
  },
  {
    title: lang.menu.ads.title,
    icon: '/images/ad.svg',
    route: { name: 'ads' },
    info: lang.menu.ads.info,
  },
  {
    title: lang.menu.profile.title,
    icon: '/images/profile.svg',
    route: { name: 'profile' },
    info: lang.menu.profile.info,
  },
  {
    title: 'upload selfie',
    icon: 'images/share.png',
    route: { name: 'upload'},
    info: 'upload selfie'
  },
  {
    title: lang.menu.logout.title,
    icon: '/images/logout.svg',
    route: { name: 'logout' },
    info: lang.menu.logout.info,
  },
];

@Component({
  components: {
    Logo,
  },
})
export default class Sidebar extends Vue {
  private items: object[] = items;

  private get active() {
    return this.$route.name;
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>
