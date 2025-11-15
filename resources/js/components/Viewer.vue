<template>
  <!-- <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <button class="btn btn-success" @click="joinBroadcast">
          Join Stream</button
        ><br />

        <video autoplay ref="viewer"></video>
      </div>
    </div>
  </div> -->

<div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-sm-flex d-block pb-0 border-0">
                            <div class="d-flex align-items-center">
                                <span class="p-3 mr-3 rounded bg-info">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.8586 5.22599L5.87121 10.5543C5.50758 11.0846 5.64394 11.8068 6.17172 12.1679L11.1945 15.6098V18.9558C11.1945 19.5921 11.6995 20.125 12.3359 20.1376C12.9874 20.1477 13.5177 19.625 13.5177 18.976V15.0013C13.5177 14.6174 13.3283 14.2588 13.0126 14.0442L9.79041 11.8346L12.5025 8.95836L13.8914 12.1225C14.0758 12.5442 14.4949 12.817 14.9546 12.817H19.1844C19.8207 12.817 20.3536 12.3119 20.3662 11.6755C20.3763 11.024 19.8536 10.4937 19.2046 10.4937H15.7172C15.2576 9.44824 14.7677 8.41288 14.3409 7.35228C14.1237 6.81693 14.0025 6.5846 13.6036 6.21592C13.5227 6.14016 12.9596 5.62501 12.4571 5.16541C11.995 4.74619 11.2828 4.77397 10.8586 5.22599Z" fill="white"/>
                                        <path d="M15.6162 5.80681C17.0861 5.80681 18.2778 4.61517 18.2778 3.1452C18.2778 1.67523 17.0861 0.483582 15.6162 0.483582C14.1462 0.483582 12.9545 1.67523 12.9545 3.1452C12.9545 4.61517 14.1462 5.80681 15.6162 5.80681Z" fill="white"/>
                                        <path d="M4.89899 23.5164C7.60463 23.5164 9.79798 21.3231 9.79798 18.6174C9.79798 15.9118 7.60463 13.7184 4.89899 13.7184C2.19335 13.7184 0 15.9118 0 18.6174C0 21.3231 2.19335 23.5164 4.89899 23.5164Z" fill="white"/>
                                        <path d="M19.101 23.5164C21.8066 23.5164 24 21.3231 24 18.6174C24 15.9118 21.8066 13.7184 19.101 13.7184C16.3954 13.7184 14.202 15.9118 14.202 18.6174C14.202 21.3231 16.3954 23.5164 19.101 23.5164Z" fill="white"/>
                                    </svg>
                                </span>
                                <div class="mr-auto pr-3">
                                    <h4 class="text-black fs-20">Live Streaming</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-0 mb-4">
                            <div class="bg-video-wrap" style="height:80vh">
                                <video autoplay ref="viewer" class="w-100" v-if="videoStreaming">
                                </video>
                                <div class="overlay" id="overlay-remove" style="height:80vh">
                                </div>
                                <p class="p2 visible-false">Start You Live Stream</p>
                                <p class="p2 visible-false-joining" style="display:none">Joining Session ....</p>
                                <button class="flex-c-m btn-primary rounded size3 s2-txt3 trans-04 where1" id="start-streaming" v-if="joinStreaming" @click="joinBroadcast" style="text-align: center;position: absolute; top: 30px; bottom: 0; left: 0; right: 0; margin: auto; z-index: 2; max-width: 400px; height: 50px;">
                                    Join Stream
                                </button>
                                <a href="/stream/rating" v-if="endStreaming" class="flex-c-m btn-primary rounded size3 s2-txt3 trans-04 where1" id="close-streaming" style="position:absolute;top:5px;right:7px;z-index:2;border-color: rgb(255, 40, 92);background: linear-gradient(to right, #ff285c, #ff285c);">
                                    End Stream
                                </a>
                              </div>
                        </div>
                    </div>
                </div>
</template>

<script>
import Peer from "simple-peer";
export default {
  name: "Viewer",
  props: [
    "auth_user_id",
    "stream_id",
    "turn_url",
    "turn_username",
    "turn_credential",
  ],
  data() {
    return {
        streamingPresenceChannel: null,
        broadcasterPeer: null,
        broadcasterId: null,
        videoStreaming:false,
        joinStreaming:true,
        endStreaming:false,
    };
  },

  methods: {
    joinBroadcast() {
      this.initializeStreamingChannel();
      this.initializeSignalOfferChannel(); // a private channel where the viewer listens to incoming signalling offer
      this.startUserStreamSession();
        $('.visible-false').hide();
        $('#start-streaming').hide();
        $('.visible-false-joining').css("display","revert");
    },

    initializeStreamingChannel() {
      this.streamingPresenceChannel = window.Echo.join(
        `streaming-channel.${this.stream_id}`
      );
    },

    createViewerPeer(incomingOffer, broadcaster) {
      const peer = new Peer({
        initiator: false,
        trickle: false,
          config: {
                // iceServers: [
                //     {
                //         urls: "stun:stun.stunprotocol.org",
                //     },
                //     {
                //         urls: this.turn_url,
                //         username: this.turn_username,
                //         credential: this.turn_credential,
                //     },
                // ],
            },



      });

      // Add Transceivers
      peer.addTransceiver("video", { direction: "recvonly" });
      peer.addTransceiver("audio", { direction: "recvonly" });
        $('.visible-false').hide();
        $('#overlay-remove').removeClass('overlay');

      // Initialize Peer events for connection to remote peer
      this.handlePeerEvents(
        peer,
        incomingOffer,
        broadcaster,
        this.removeBroadcastVideo
      );

      this.broadcasterPeer = peer;
    },

    handlePeerEvents(peer, incomingOffer, broadcaster, cleanupCallback) {
      peer.on("signal", (data) => {
        axios
          .post("/stream-answer", {
            broadcaster,
            answer: data,
          })
          .then((res) => {
            if(res.status){

                $('.visible-false-joining').css("display","none");
            }
          })
          .catch((err) => {
            console.log(err);
          });
      });

      peer.on("stream", (stream) => {
        // display remote stream
        this.$refs.viewer.srcObject = stream;
      });

      peer.on("track", (track, stream) => {
        console.log("onTrack");
      });

      peer.on("connect", () => {
        console.log("Viewer Peer connected");
      });

      peer.on("close", () => {
        console.log("Viewer Peer closed");
        peer.destroy();
        cleanupCallback();
      });

      peer.on("error", (err) => {
        console.log(err);
        console.log("handle error gracefully");
      });

      const updatedOffer = {
        ...incomingOffer,
        sdp: `${incomingOffer.sdp}\n`,
      };
      peer.signal(updatedOffer);
    },

    initializeSignalOfferChannel() {

      window.Echo.private(`stream-signal-channel.${this.auth_user_id}`).listen(
        "StreamOffer",
        ({ data }) => {
            this.joinStreaming=false,
            this.videoStreaming=true;
            this.endStreaming=true;
          console.log("Signal Offer from private channel",data);
          this.broadcasterId = data.broadcaster;
          this.createViewerPeer(data.offer, data.broadcaster);
        }
      );
    },
       removeBroadcastVideo() {
                console.log("removingBroadcast Video");
                //  window.location.href("/stream/rating");
                 window.location.replace("/stream/rating");
                const tracks = this.$refs.viewer.srcObject.getTracks();
                tracks.forEach((track) => {
                    track.stop();
                });
                this.$refs.viewer.srcObject = null;
            },
        startUserStreamSession() {
        axios.post("/join/stream/session")
            .then((res) => {
                console.log(res);
                if(res.data.status===false){
                        $('.visible-false').show();
                        $('#start-streaming').show();
                        $('.visible-false-joining').css("display","none");
                        alert('streaming not start yet');
                }
            })
            .catch((err) => {
                console.log(err);
            });
    },


  },
};
</script>

<style scoped>
</style>
