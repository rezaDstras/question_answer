<template>
  <v-container
            fluid
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col
                    cols="12"
                    sm="8"
                    md="4"
                >
                    <v-card class="elevation-12">
                        <v-toolbar
                            color="primary"
                            dark
                            flat
                        >
                            <v-toolbar-title>Register</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field
                                    label="Name"
                                    name="name"
                                    prepend-icon="mdi-account"
                                    type="text"
                                ></v-text-field>

                                <v-text-field
                                    label="Email"
                                    name="email"
                                    prepend-icon="mdi-email"
                                    type="email"
                                ></v-text-field>

                                <v-text-field
                                    id="password"
                                    label="Password"
                                    name="password"
                                    prepend-icon="mdi-lock"
                                    type="password"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" >Register</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
</template>

<script>
    export default {
        name: "Register"
    }
</script>

<style scoped>

</style>
