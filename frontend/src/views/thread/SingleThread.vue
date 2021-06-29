<template>
    <v-container>
        <v-row
            justify="center"
            content="center"
        >
            <v-col
                cols="12"
                md="8"
            >
                <v-card
                    outlined
                >
                    <v-card-title>
                        <h2>Laravel Error</h2>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col>
                                <p>Reza Dastras</p>
                            </v-col>
                            <v-col>
                                <p class="text-right">2021/10/20 9:30</p>
                            </v-col>
                        </v-row>
                        <vue-markdown>
                            # My Markdown Test
                            [Google](https://google.com)
                            :)
                        </vue-markdown>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                md="8"
            >
                <v-row>
                    <v-col >
                        <h2>Replies :</h2>
                    </v-col>
                    <v-col class="text-right">
                        <v-btn
                            ripple
                            to="#"
                            color="green"
                            dark
                        >
                            Reply
                        </v-btn>
                    </v-col>
                </v-row>

            </v-col>
            <v-row
                justify="center"
                content="center"
            >
                <v-col
                    cols="12"
                    md="8"
                >
                    <v-card
                        outlined
                        dark
                    >
                        <v-card-title>
                            <v-avatar
                                color="orange"
                                size="62"
                            >
                                ehsan
                            </v-avatar>
                            <v-row>
                                <v-col>
                                    <h5 class="ml-6">Esan dastras</h5>
                                </v-col>
                                <v-col class="text-right">
                                    <small class="grey--text" style="font-size: 10pt">2021/12/5 20:30</small>
                                </v-col>
                            </v-row>
                        </v-card-title>
                        <v-card-text>
                            <p>In publishing and graphic design, Lorem ipsum is
                                a placeholder text commonly used to
                                demonstrate the visual form of a document or a
                                typeface without relying on meaningful content
                                . Lorem ipsum may be used as a placeholder before
                                final copy is available.
                            </p>
                        </v-card-text>
                    </v-card>

                </v-col> <v-col
                    cols="12"
                    md="8"
                >
                    <v-card
                        outlined
                        dark
                    >
                        <v-card-title>
                            <v-avatar
                                color="orange"
                                size="62"
                            >
                                ehsan
                            </v-avatar>
                            <v-row>
                                <v-col>
                                    <h5 class="ml-6">Esan dastras</h5>
                                </v-col>
                                <v-col class="text-right">
                                    <small class="grey--text" style="font-size: 10pt">2021/12/5 20:30</small>
                                </v-col>
                            </v-row>
                        </v-card-title>
                        <v-card-text>
                            <vue-markdown>
                                this is the default slot
                                In publishing and graphic design, Lorem ipsum is
                                a placeholder text commonly used to
                                demonstrate the visual form of a document or a
                                typeface without relying on meaningful content
                                . Lorem ipsum may be used as a placeholder before
                                final copy is available.
                            </vue-markdown>
                        </v-card-text>
                    </v-card>

                </v-col>
            </v-row>
        </v-row>
    </v-container>
</template>

<script>
    import VueMarkdown from 'vue-markdown/src/VueMarkdown'
    export default {
        name: "SingleThread",
        components: {
            VueMarkdown
        }
    }
</script>

<style scoped>

</style>
