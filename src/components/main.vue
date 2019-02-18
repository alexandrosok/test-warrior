<template>
    <div v-if="!status" class="app-container">
        <v-toolbar fixed>
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title>Manowarrior Metre
                | This is your fucking score:<span class="container">{{score}}</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
            </v-toolbar-items>
        </v-toolbar>
        <v-container id="app-container" fluid>
            <v-container grid-list-md text-xs-center>
                <v-layout row wrap>
                    <v-flex xs4 v-for="(value , index) in data" :key="index">
                        <v-card>
                            <v-img
                                    :src="`/static/${value.image}`"
                                    aspect-ratio="1.75"
                            ></v-img>

                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">{{value.question}}</h3>
                                    <div></div>
                                </div>
                            </v-card-title>

                            <v-card-actions>
                                <v-select
                                        :id="`answer_${index}`"
                                        @change="submitAnswer($event , index)"
                                        :items="value.answers"
                                ></v-select>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
            <div class="text-xs-center">
                <v-dialog
                        v-model="dialog"
                        width="500"
                >
                    <v-card>
                        <v-card-title
                                class="headline grey lighten-2"
                                primary-title
                        >
                            Submit your answer. You have only one try
                        </v-card-title>

                        <v-card-text>
                            Are you sure
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                    color="primary"
                                    flat
                                    @click="confirm()"
                            >
                                Yeah
                            </v-btn>
                            <v-btn
                                    color="primary"
                                    flat
                                    @click="dialog = false"
                            >
                                No...
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog
                        v-model="finalDialog"
                        width="500"
                >
                    <v-card>
                        <v-card-title
                                class="headline grey lighten-2"
                                primary-title
                        >
                            This is your fucking score. {{score}}
                        </v-card-title>

                        <v-card-text>
                            {{resultMessage}}
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog
                        persistent
                        v-model="emailDialog"
                        width="1000"
                        :rules="[rules.required, rules.email]"
                >
                    <v-card>
                        <v-card-title
                                class="headline grey lighten-2"
                                primary-title
                        >
                            This app is shared between friends
                            and it is a false detector.
                            <br/>
                            Enter you stuff so all your friends know
                            what a koulouri you are.
                        </v-card-title>
                        <v-card-text>
                            <v-flex>
                                <v-flex>
                                    <v-text-field
                                            v-model="email"
                                            :rules="[rules.required, rules.email]"
                                            label="E-mail"
                                    ></v-text-field>
                                    <v-text-field
                                            v-model="name"
                                            label="Name"
                                    ></v-text-field>
                                    Hooman Detector
                                    <v-text-field
                                            v-model="hooman"
                                            label="Type hooman if you are a hooman"
                                    ></v-text-field>
                                </v-flex>
                            </v-flex>
                        </v-card-text>

                        <v-divider></v-divider>
                        <v-btn @click="submitEmail">
                            Submit
                        </v-btn>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-container>
    </div>
    <v-container class="display-3 color-white" id="app-container" v-else-if="status">
        <div class="result-text">
            <div>
                {{resultMessage}}
            </div>
            You had only once chance to test your metalness. Now fuck off wanker...
        </div>
    </v-container>
</template>

<script>

    import data from '../../static/questions'

    export default {
        name: 'Main',
        data() {
            return {
                data,
                score: 0,
                selection: false,
                dialog: false,
                confirmSelection: false,
                emailDialog: false,
                answer: null,
                email: null,
                finalDialog: false,
                name: null,
                index: null,
                hooman: null,
                target: null,
                clicked: false,
                counter: 0,
                counterEnd: 22,
                status: window.localStorage.getItem('end-mew'),
                resultMessage: window.localStorage.getItem('warrior-result-new'),
                rules: {
                    required: value => !!value || 'Required.',
                    counter: value => value.length <= 20 || 'Max 20 characters',
                    email: value => {
                        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        return pattern.test(value) || 'Invalid e-mail.'
                    }
                }
            }
        },
        beforeMount() {
            if (!this.status) {
                this.emailDialog = true
            }
        },
        methods: {
            confirm() {
                this.dialog = false
                let target = document.querySelector('#answer_' + this.index)
                if (this.answer === data[this.index].correct_answer) {
                    target.parentNode.parentNode.style.backgroundColor = 'green'
                    this.score = this.score + 1
                }
                else {
                    target.parentNode.parentNode.style.backgroundColor = 'red'
                }
                target.parentNode.parentNode.parentNode.classList.add('disabled')

                this.counter = this.counter + 1
                if (this.counter === this.counterEnd) {

                    if (this.score === 22) {
                        this.resultMessage = 'Hail true Manowarrior'
                    }
                    if (this.score >= 15 || this.score <= 21) {
                        this.resultMessage = 'You were okey , but you still suck. Leave The fucking hall'
                    }
                    if (this.score <= 14) {
                        this.resultMessage = 'You are a wimp and a poser. Leave the fucking hall'
                    }

                    let settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": `https://manowarrior.dungeonmastering.net/API/final.php?email=${this.email}&name=${this.name}&score=${this.score}`,
                        "method": "POST",
                        "headers": {
                            "Content-Type": "application/json",
                            "cache-control": "no-cache",
                        }
                    }
                    this.$http(settings).then((response) => {
                        console.log(response)
                    })

                    window.localStorage.setItem('end-mew', true)
                    window.localStorage.setItem('warrior-result-new', this.resultMessage)
                    this.finalDialog = true
                }
            },
            submitAnswer(event, index) {
                this.dialog = true
                this.index = index
                this.answer = event
            },
            submitEmail() {
                if (this.hooman === 'hooman') {
                    if (this.rules.email(this.email) && this.name) {
                        let settings = {
                            "async": true,
                            "crossDomain": true,
                            "url": `https://manowarrior.dungeonmastering.net/API/manager.controller.php?email=${this.email}&name=${this.name}`,
                            "method": "POST",
                            "headers": {
                                "Content-Type": "application/json",
                                "cache-control": "no-cache",
                            }
                        }
                        this.$http(settings).then((response) => {
                            console.log(response)
                        })
                    }
                    this.emailDialog = false
                }
            }
        }
    }
</script>

<style>

    .result-text {
        padding: 20%;
        background: #635b5b40;
    }

    .color-white {
        color: white;
    }

    .app-container {
        padding-top: 70px;
    }

    .disabled {
        pointer-events: none;
    }

    #app-container {
        background: url('../../static/mm.jpg') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

    .app-container-wrapper {
        background: white;
    }

    .score-container {
        text-align: center;
        font-size: 60px;
    }

    .v-card__title--primary {
        height: 104px;
    }

    .choice-item {
        border: 1px solid red;
        padding: 10px;
        width: 200px;
        cursor: pointer;
    }
</style>
