<template>
  <header class="_header">
    <div class="_grid">
      <h1 class="_header__title" v-if="title && title.length">{{ title }}</h1>
    </div>
    <Sidebar />
  </header>
 
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import Logo from '@/components/Logo.vue';
import SidebarToggle from '@/components/SidebarToggle.vue';
import Sidebar from '@/components/Sidebar.vue';

@Component({
  components: {
    Logo,
    SidebarToggle,
    Sidebar,
  },
})
export default class Header extends Vue {
  @Prop() private title!: string;
}
</script>

 