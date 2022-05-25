<template>
    <div >
        <v-dialog
            v-model="dialog"
            width="500"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    v-on="on"
                    v-bind="attrs"
                    icon>
                    <v-icon color="blue">
                        mdi-message-bulleted
                    </v-icon>
                </v-btn>
            </template>

            <v-card>
                <v-card-title
                    class="text-h5 grey lighten-2">
                    Комментарии
                </v-card-title>

                <v-card-text>
                    <v-text-field
                        placeholder="Комментарий"
                        height="150"
                        dense
                    ></v-text-field>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        @click="dialog = false"
                    >
                        Сохранить
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>
    </div>
</template>

<script>
export default {
    data () {
        return {
            dialog: false,
        }
    },
}
</script>

<style scoped>
</style>
