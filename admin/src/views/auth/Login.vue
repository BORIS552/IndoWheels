<template>
  <div class="_auth _login">
    <Logo class="_auth__logo" />
    <LoginForm class="_auth__form" />
    <Loader :is-busy="isBusy" />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Logo from '@/components/Logo.vue'; // @ is an alias to /src
import LoginForm from '@/components/auth/LoginForm.vue';
import Loader from '@/components/Loader.vue';

@Component({
  components: {
    Logo,
    LoginForm,
    Loader,
  },
})
export default class Login extends Vue {

  private get isBusy(): boolean {
    if (this.$store.state.auth) {
      return this.$store.state.auth.isBusy;
    }
    return false;
  }

}
</script>
