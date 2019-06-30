<template>
  <div class="_profile">
    <Header :title="title" />
    <Sidebar />
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <ProfileForm />
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import ProfileForm from '@/components/profile/ProfileForm.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
    ProfileForm,
  },
})
export default class Profile extends Vue {
  private title: string = lang.profile.name;

  private mounted(): void {
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }
}
</script>
