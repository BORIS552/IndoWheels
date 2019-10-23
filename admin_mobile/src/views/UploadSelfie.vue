<template>
  <div class="_profile">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <br/>
      <br/>
     <form class="_form _winnerProfile__form" @submit.prevent="onSubmit" ref="form">
      <input type="text" readonly="" @click="onFileSelect('selfie')" class="_input" :placeholder="lang.form.selfieCopy" :value="selfieName" />
        <input type="file" name="selfie" ref="selfie" capture="user" @input="onSelfieSelect" accept="image/*" />
        <br/>
        <br/>
      <div class="_fieldset">
        <input type="submit" class="_btn" :value="lang.form.submit">
      </div>
  </form>
      <br/>
      <br/>
      <br/>
      <br/>
      <iframe v-if="this.selfie_url != '' " class="_btn _sm" :src="`${getFacebookShare()}`" width="90" height="25" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import lang from '@/lang/en';
import axios from 'axios';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
  },
})
export default class UploadSelfie extends Vue {
  private title: string = 'Upload Selfie';
  private lang: any = lang;
  private selfieName: string = '';
  private selfie_url: string = '';
  private isBusy: boolean = false;
  private mounted(): void {
    document.title = 'Upload Selfie';
  }

   private onSelfieSelect(): string | void {
    const fileEle = this.$refs.selfie as HTMLFormElement;
    if (fileEle && fileEle.files && fileEle.files.length) {
      this.selfieName = fileEle.files[0].name;
    } else {
      this.selfieName = '';
    }
  }


   private getFormData(): any {
    const form = this.$refs.form as HTMLFormElement;
    const data = new FormData(form);
    return data;
  }

  private async onSubmit() {
    this.isBusy = true;
    const url = `http://api.lotteryindowheels.in/api/uploadselfie`;
    axios.post(url, this.getFormData())
      .then((response) => {
        console.log(response.data);
        this.selfie_url = 'http://api.lotteryindowheels.in/storage/'+response.data;
        console.log(this.selfie_url);
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        this.isBusy = false;
      });
  }

  private getFacebookShare(): any {
    const encodedURL = encodeURIComponent(this.selfie_url);
    const facebook_url = "https://www.facebook.com/plugins/share_button.php?href="+encodedURL+"&layout=button_count&size=small&width=90&height=25&appId";

    return facebook_url;
  }
}
</script>
