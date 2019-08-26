<template>
    <div>
        <VHeader></VHeader>
        <div id="container" class="mainnav-lg">
            <VSidebar></VSidebar>
            <div id="page-content">
                <router-view :key="$route.fullPath"></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "VApp"
    }
</script>

<style scoped>

</style>