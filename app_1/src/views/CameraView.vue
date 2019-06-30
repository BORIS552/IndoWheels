<template>
   <div class="camera-modal">
        <video v-show="captureStatus" ref="video" class="camera-stream"/>
        <canvas v-show="captureStatus" ref="canvas" id="canvas" width="640" height="480"><p>Testing</p></canvas>
        <img v-show="captureStatus" v-bind:src="captureData" height="50" />
         <div class="camera-modal-container">
            <span @click="capture" class="take-picture-button take-picture-button mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
              <i class="material-icons">camera</i>
            </span>
            <button @click="back"><img src="/images/back_arrow.svg" alt="" class="back_arrow" /></button>
        </div>

    </div>
</template>

<script>
  export default {
  data () {
      return {
        mediaStream: null,
        captureStatus: false,
        captureData: {},
        canvas: {},
      }
    },
   mounted() {
      navigator.mediaDevices.getUserMedia({ video: { facingMode: { exact: "environment" } } })
        .then(mediaStream => {
        this.mediaStream = mediaStream
          this.$refs.video.srcObject = mediaStream
          this.$refs.video.play();
        })
        .catch(error => console.error('getUserMedia() error:', error))
    },
    methods: {
    capture () {
      const mediaStreamTrack = this.mediaStream.getVideoTracks()[0]
      const imageCapture = new window.ImageCapture(mediaStreamTrack)
      
      this.captureStatus = true;
      this.canvas = this.$refs.canvas;
      this.canvas.getContext("2d").drawImage(imageCapture, 0, 0, 640, 480);
      this.captureData = this.canvas.toDataURL("image/png");

      return imageCapture.takePhoto().then(blob => {
      console.log(blob);
    })
  },

  back() {
    console.log("back clicked");
    this.$router.go(-1);
  }

  },
  destroyed () {
    const tracks = this.mediaStream.getTracks()
    tracks.map(track => track.stop())
  }



  }
</script>

<style scoped>
.camera-modal {
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: absolute;
        background-color: white;
        z-index: 10;
    }
    .camera-stream {
        width: 100%;
        max-height: 100%;
    }
  .camera-modal-container {
        position: absolute;
        bottom: 0;
        width: 100%;
        align-items: center;
        margin-bottom: 24px;
    }
    .take-picture-button {
        display: flex;
    }
</style>