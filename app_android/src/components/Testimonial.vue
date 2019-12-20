<template>
  <blockquote class="_blockquote" :style="style">
    <h4 class="_blockquote__headline">{{ title }}</h4>
    <q class="_blockquote__quote">{{ quote }}</q>
    <cite class="_blockquote__cite">{{ cite }}</cite>
  </blockquote>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import Curve from '@/components/Curve.vue';

@Component({
  components: {
    Curve,
  },
})
export default class Header extends Vue {
  @Prop() private title!: string;
  @Prop() private quote!: string;
  @Prop() private cite!: string;
  @Prop() private image!: string;

  private get style(): object {
    return {
      backgroundImage: `url(${this.image})`,
    };
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>
