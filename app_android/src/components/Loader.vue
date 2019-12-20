<template>
    <div class="_loader" v-show="isBusy">
        <div class="_loader__eclipse">
            <div class="_loader__spinner"></div>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class Loader extends Vue {
  @Prop() private isBusy!: boolean;
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>
