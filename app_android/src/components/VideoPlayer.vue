<template>
  <div class="_video">
    <div class="_video__frame">
      <video class="_video__player" :poster="poster" ref="player" @click="onToggle">
        <source :src="src">
        {{ lang.common.videoPlayerNotSupported }}
      </video>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import lang from '@/lang/en';

@Component
export default class VideoPlayer extends Vue {

  @Prop() private id!: number;
  @Prop() private src!: string;
  @Prop() private poster!: string;

  private lang: any = lang;

  private get eleVideo(): HTMLVideoElement {
    return this.$refs.player as HTMLVideoElement;
  }

  private onToggle() {
    if (this.eleVideo.paused) {
      this.eleVideo.play();
    } else {
      this.eleVideo.pause();
    }
  }

  @Watch('id')
  private onIdChange() {
    this.eleVideo.load();
    this.eleVideo.play();
  }

}
</script>
