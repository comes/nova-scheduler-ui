<template>
    <div>
        <heading class="mb-6">Nova Scheduler Ui</heading>
    </div>
</template>

<script>

export default {
    data: () => ({
        loading: true,

        resource: {},

    }),
    metaInfo() {
        return {
            title: 'NovaSchedulerUi',
        }
    },
    /**
     * Mount the component and retrieve its initial data.
     */
    mounted() {
    }
}
</script>

<style>
/* Scoped Styles */
</style>
