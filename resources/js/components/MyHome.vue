<template>
    <div>
        <h4>My home component: {{ this.myData  }}</h4>
        <h4>My home component: {{ this.myData2  }}</h4>
    </div>

</template>

<script>
export default {
    name: "MyHome",
    data() {
        return {
            myData: null,
            myData2: null,
        }
    },
    methods: {
        myMethod() {
            api.call(endpoint('my-home'))
                .then(response => {
                    this.myData = response.data;
                });
        },

        myMethod2() {
            api.call(endpoint('my-home-2'))
                .then(response => {
                    this.myData2 = response.data;
                });
        }

    },
    created() {
        this.myMethod();
        this.myMethod2();
    }
}
</script>

<style scoped>

</style>
