<template>
    <div>
        <transition name="scale" mode="out-in">
            <router-view :key="$route.fullPath"></router-view>
        </transition>

    </div>
</template>

<script>

    export default {
    }
</script>
