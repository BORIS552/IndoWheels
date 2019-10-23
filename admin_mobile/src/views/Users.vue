<template>
  <div class="_users">
    <Header :title="title" />
    <Sidebar />
    <Loader :is-busy="isBusy" />
      <br/>
      <br/>
    <main class="_main">
      <button class="_btn" @click="onAdd">Add New</button>
      <UsersList :at-edit="onEdit" />
    </main>
    <div class="_modal" :class="{ _on: isModalOpen }">
      <div class="_modal__dialog">
        <div class="_modal__body">
          <UsersForm :model="model" :at-store="onModalClose" />
        </div>
      </div>
      <div class="_modal__overlay" @click="onModalClose"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import UsersList from '@/components/users/UsersList.vue';
import UsersForm from '@/components/users/UsersForm.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    UsersList,
    UsersForm,
    Loader,
  },
})
export default class Users extends Vue {

  private title: string = lang.home.name;
  private model: object = {};
  private isModalOpen: boolean = false;

  private mounted(): void {
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.users.isBusy;
  }

  private onAdd() {
    this.model = {};
    this.isModalOpen = true;
  }

  private onEdit(model: any) {
    this.model = model;
    this.isModalOpen = true;
  }

  private onModalClose() {
    this.model = {};
    this.isModalOpen = false;
  }

}
</script>
