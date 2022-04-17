<template>
    <div class="d-flex justify-content-start">
        <button @click="decrement" :disabled="count === 0" class="btn btn-sm btn-primary">-</button>
        <div class="px-4 mx-1">{{ count }}</div>
        <button @click="increment" :disabled="count === max" class="btn btn-sm btn-primary">+</button>
    </div>
</template>

<script>
export default {
    name: "Counter",
    props: {
        max: Number
    },
    data() {
        return {
            count: 0,
        }
    },
    methods: {
        increment: function() {
           this.count++;
            this.$emit('countChanged', this.count)
        },
        decrement: function() {
            this.count--;
            this.$emit('countChanged', this.count)
        }
    }
}
</script>
