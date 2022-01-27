<template>
    <v-card-actions>
                    <v-btn @click="close"
                        outlined
                        rounded
                        text>
                        Отмена
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        outlined
                        rounded
                        text
                        color="primary">
                        Сохранить
                    </v-btn>

                </v-card-actions>

</template>
<script>
export default {
    data() {
        return {
            touchOpen: false
        }


    },
    methods: {
        close() {
            this.$emit('Cancel', false);
        },

    }
}

</script>
