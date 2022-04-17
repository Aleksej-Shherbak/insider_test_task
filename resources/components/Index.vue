<template>
    <div>
        <nav class="navbar bg-white border-bottom navbar-light">
            <div class="container">
                <router-link class="navbar-brand mr-auto" :to="{name: 'home'}">Home</router-link>
            </div>
        </nav>

        <div class="container my-4 px-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "Index",
}
</script>
