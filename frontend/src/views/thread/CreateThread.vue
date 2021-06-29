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
            <v-card>
                <v-card-text>
                    <h2>Create New Thread</h2>
                </v-card-text>
                <v-card-text>
                    <v-form>
                        <v-text-field
                            label="Title"
                            name="title"
                            type="text"
                            outlined
                        ></v-text-field>
                        <v-textarea
                            outlined
                            id="password"
                            label="Content"
                            name="content"
                            value=""
                        ></v-textarea>
                        <v-select
                            label="Channel"
                             outlined
                            >
                        </v-select>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        ripple
                        color="blue"
                        dark
                    >
                        Submit
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "CreateThread"
    }
</script>

<style scoped>

</style>
