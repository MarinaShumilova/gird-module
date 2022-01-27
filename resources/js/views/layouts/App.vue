<template>
    <base-layout :drawerItems="drawerItems"/>
</template>

<script>
    import BaseLayout from 'gird-base-front/src/views/layouts/baseLayout';

    export default {
        name: "App",
        components: {BaseLayout},
        data() {
            return {
                drawer: true,
                drawerItems: [
                    {
                        text: 'Home',
                        icon: 'mdi-home',
                        to: { name: 'home' },
                        exact: true,
                        //show: () => { return true }   // будет ли показан пункт меню
                    },
                ]
            }
        },
    }
</script>

<style scoped>

</style>
