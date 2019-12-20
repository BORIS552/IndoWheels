<template>
  <aside :class="['_sidebar', cssClass]">
    <ul class="_menu">
      <li v-for="(item, index) in items" ::key="index" class="_menu__item">
        <router-link :to="item.route" class="_menu__link">
          <!-- <img :src="item.icon" alt="" class="_menu__item__icon"> -->
          <i class="_menu__item__icon" :class="item.fontIcon"></i>
          <span class="_menu__item__title">{{ item.title }}</span>
          <!-- <span class="_menu__item__info">{{ item.info }}</span> -->
        </router-link>
      </li>
    </ul>
    <div class="_sidebar__overlay" @click="onClose"></div>
  </aside>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch } from 'vue-property-decorator';
import * as types from '@/mutation-types';
import Logo from '@/components/Logo.vue';
import lang from '@/lang/en';

const items = [
  {
    title: 'Home',
    icon: '/images/home.svg',
    route: { name: 'home' },
    info: lang.menu.profile.info,
    fontIcon: 'icon-home',
  },
  {
    title: lang.menu.contactDetails.title,
    icon: '/images/customer-support.svg',
    route: { name: 'contact.index' },
    info: lang.menu.contactDetails.info,
    fontIcon: 'icon-call-out',
  },
  // {
  //   title: lang.menu.contact.title,
  //   icon: '/images/email.svg',
  //   route: { name: 'contact.form' },
  //   info: lang.menu.contact.info,
  // },
  {
    title: lang.menu.reviews.title,
    icon: '/images/trophy.svg',
    route: { name: 'reviews' },
    info: lang.menu.reviews.info,
    fontIcon: 'icon-trophy',
  },
  // {
  //   title: lang.menu.textReview.title,
  //   icon: '/images/vote.svg',
  //   route: { name: 'reviews.create' },
  //   info: lang.menu.textReview.info,
  // },
  {
    title: lang.menu.videos.title,
    icon: '/images/camera.svg',
    route: { name: 'videos' },
    info: lang.menu.videos.info,
    fontIcon: 'icon-social-youtube',
  },
  {
    title: lang.menu.profile.title,
    icon: '/images/profile.svg',
    route: { name: 'profile' },
    info: lang.menu.profile.info,
    fontIcon: 'icon-user',
  },
  {
    title: lang.menu.logout.title,
    icon: '/images/logout.svg',
    route: { name: 'logout' },
    info: lang.menu.logout.info,
    fontIcon: 'icon-logout',
  },
];

@Component({
  components: {
    Logo,
  },
})
export default class Sidebar extends Vue {
  private items: object[] = items;

  private onClose() {
    this.$store.commit(types.SIDEBAR_HIDE);
  }

  private get cssClass() {
    return {
      _on: this.$store.state.sidebar.isOn,
    };
  }

  private get route() {
    return this.$route.name;
  }

  @Watch('route')
  private onRouteChange():void {
    this.onClose();
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>
