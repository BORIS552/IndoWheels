<template>
  <div class="_profile__form">
    <ProfileFormName />
    <ProfileFormEmail />
    <ProfileFormPhone />
    <!-- <ProfileFormPassword /> -->
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import ProfileFormName from '@/components/profile/ProfileFormName.vue';
import ProfileFormEmail from '@/components/profile/ProfileFormEmail.vue';
import ProfileFormPhone from '@/components/profile/ProfileFormPhone.vue';
import ProfileFormPassword from '@/components/profile/ProfileFormPassword.vue';
import lang from '@/lang/en';

@Component({
  components: {
    ProfileFormName,
    ProfileFormEmail,
    ProfileFormPhone,
    ProfileFormPassword,
  },
})
export default class ProfileForm extends Vue {

}
</script>
