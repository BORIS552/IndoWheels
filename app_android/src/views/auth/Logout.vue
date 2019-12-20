<template>
  <div class="_logout"></div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import utils from '@/utils';

@Component
export default class Logout extends Vue {

  private mounted(): void {
    this.logout();
  }

  private logout(): void {
    this.$store.dispatch('authLogout');
    utils.removeAccessToken();
    utils.removeAxiosAccessToken();
    this.$router.push({ name: 'login' });
  }

}
</script>
