<template>
  <div class="_profile">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <!-- <Cover :headline="title" :tagline="lang.contactDetails.tagline" /> -->
      <ProfileForm />
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import * as types from '@/mutation-types';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Cover from '@/components/Cover.vue';
import Loader from '@/components/Loader.vue';
import ProfileForm from '@/components/profile/ProfileForm.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
    ProfileForm,
    Cover,
  },
})
export default class Profile extends Vue {

  private title: string = lang.profile.name;
  private lang: any = lang;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }

}
</script>
