<template>
  <!-- <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <button class="btn btn-success" @click="startStream">
          Start Stream</button
        ><br />
        <p v-if="isVisibleLink" class="my-5">
          Share the following streaming link: {{ streamLink }}
        </p>
        <video autoplay ref="broadcaster"></video>
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
                                <video autoplay ref="broadcaster" class="w-100" v-if="videoStreaming" muted>
                                </video>
                                <div class="overlay" id="overlay-remove" style="height:80vh">
                                </div>
                                <p class="p2 visible-false">Start You Live Stream</p>
                                <button class="flex-c-m btn-primary rounded size3 s2-txt3 trans-04 where1" id="start-streaming" v-if="startStreaming"  @click="startStream" style="text-align: center;position: absolute; top: 30px; bottom: 0; left: 0; right: 0; margin: auto; z-index: 2; max-width: 400px; height: 50px;">
                                    Start Stream
                                </button>
                                <button class="flex-c-m btn-primary rounded size3 s2-txt3 trans-04 where1" id="close-streaming" style="position:absolute;top:5px;right:7px;z-index:2;border-color: rgb(255, 40, 92);background: linear-gradient(to right, #ff285c, #ff285c);" v-if="buttonVisibilty"   @click="finishStream">
                                    End Stream
                                </button>
                              </div>
                        </div>
                    </div>
                </div>
</template>

<script>
import Peer from "simple-peer";
import { getPermissions } from "../helpers";
export default {
  name: "Broadcaster",
  props: [
    "auth_user_id",
    "env",
    "turn_url",
    "turn_username",
    "turn_credential",
  ],
  data() {
    return {
    isVisibleLink: false,
    startStreaming: true,
    videoStreaming:false,
    buttonVisibilty: false,
    streamingPresenceChannel: null,
    streamingUsers: [],
    items:[],
    currentlyContactedUser: null,
    allPeers: {},
      // this will hold all dynamically created peers using the 'ID' of users who just joined as keys
    };
  },

  computed: {
    streamId() {
      // you can improve streamId generation code. As long as we include the
      // broadcaster's user id, we are assured of getting unique streamiing link everytime.
      // the current code just generates a fixed streaming link for a particular user.
      return `${this.auth_user_id}12acde2`;
    },

    streamLink() {
      // just a quick fix. can be improved by setting the app_url
      if (this.env === "production") {
        return `https://laravel-video-call.herokuapp.com/streaming/${this.streamId}`;
      } else {
        return `http://127.0.0.1:8000/streaming/${this.streamId}`;
      }
    },
  },

  methods: {
    async startStream() {
      // const stream = await navigator.mediaDevices.getUserMedia({
      //   video: true,
      //   audio: true,
      // });
      // microphone and camera permissions
       this.startStreaming = false;
        this.buttonVisibilty = true;
        this.videoStreaming = true;
      const stream = await getPermissions();
      this.$refs.broadcaster.srcObject = stream;
        $('.visible-false').hide();
        $('#overlay-remove').removeClass('overlay');

      this.initializeStreamingChannel();
      this.initializeSignalAnswerChannel(); // a private channel where the broadcaster listens to incoming signalling answer
      this.isVisibleLink = true;
      this.startUserStreamSession();
    },

      finishStream(){
                axios.post("/admin/live/streaming/end")
                    .then((res) => {
                        console.log(res)
                        window.location.href='/admin/dashboard';
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },

    peerCreator(stream, user, signalCallback) {
      let peer;
      return {
        create: () => {
          peer = new Peer({
            initiator: true,
            trickle: false,
            stream: stream,
              // config: {
              //       iceServers: [
              //           {
              //               urls: "stun:stun.stunprotocol.org",
              //           },
              //           {
              //               urls: this.turn_url,
              //               username: this.turn_username,
              //               credential: this.turn_credential,
              //           },
              //       ],
              //   },

          });
        },

        getPeer: () => peer,

        initEvents: () => {
          peer.on("signal", (data) => {
            // send offer over here.
            signalCallback(data, user);
          });

          peer.on("stream", (stream) => {
            console.log("onStream");
          });

          peer.on("track", (track, stream) => {
            console.log("onTrack");
          });

          peer.on("connect", () => {
            console.log("Broadcaster Peer connected");
          });

          peer.on("close", () => {
            console.log("Broadcaster Peer closed");
          });

          peer.on("error", (err) => {
              console.log(err);
            console.log("handle error gracefully");
          });
        },
      };
    },

    initializeStreamingChannel() {
      this.streamingPresenceChannel = window.Echo.join(
        `streaming-channel.${this.streamId}`
      );

      this.streamingPresenceChannel.here((users) => {
        this.streamingUsers = users;
      });

      this.streamingPresenceChannel.joining((user) => {
        console.log("New User", user);
        // if this new user is not already on the call, send your stream offer
        const joiningUserIndex = this.streamingUsers.findIndex(
          (data) => data.id === user.id
        );
        if (joiningUserIndex < 0) {
          this.streamingUsers.push(user);

          // A new user just joined the channel so signal that user
          this.currentlyContactedUser = user.id;

          this.$set(
            this.allPeers,
            `${user.id}`,
            this.peerCreator(
              this.$refs.broadcaster.srcObject,
              user,
              this.signalCallback
            )
          );
          // Create Peer
          this.allPeers[user.id].create();

          // Initialize Events
          this.allPeers[user.id].initEvents();
        }
      });

      this.streamingPresenceChannel.leaving((user) => {
        console.log(user.name, "Left");
        // destroy peer
        this.allPeers[user.id].getPeer().destroy();

        // delete peer object
        delete this.allPeers[user.id];

        // if one leaving is the broadcaster set streamingUsers to empty array
        if (user.id === this.auth_user_id) {
          this.streamingUsers = [];
        } else {
          // remove from streamingUsers array
          const leavingUserIndex = this.streamingUsers.findIndex(
            (data) => data.id === user.id
          );
          this.streamingUsers.splice(leavingUserIndex, 1);
        }
      });
    },

    initializeSignalAnswerChannel() {
      window.Echo.private(`stream-signal-channel.${this.auth_user_id}`).listen(
        "StreamAnswer",
        ({ data }) => {
          console.log("Signal Answer from private channel");

          if (data.answer.renegotiate) {
            console.log("renegotating");
          }
          if (data.answer.sdp) {
            const updatedSignal = {
              ...data.answer,
              sdp: `${data.answer.sdp}\n`,
            };

            this.allPeers[this.currentlyContactedUser]
              .getPeer()
              .signal(updatedSignal);
          }
        }
      );
    },

      signalCallback(offer, user) {
                console.log(offer, user);

                axios
                    .post("/admin/live/streaming/stream-offer", {
                        broadcaster: this.auth_user_id,
                        receiver: user,
                        offer,
                    })
                    .then((res) => {
                        console.log(res);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },

            startUserStreamSession() {
                axios.post("/admin/live/streaming/start")
                    .then((res) => {
                        console.log(res);
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
