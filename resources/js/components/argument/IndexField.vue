<template>
    <div>
        <span v-if="isJob">
            <code v-text="command"></code> on Queue <code v-text="humanArgs"></code>
        </span>
        <span v-else>
            <code v-text="command"></code> <span v-if="humanArgs > 0">with arguments <code v-text="humanArgs"></code></span>
        </span>
    </div>
</template>

<script>
import cronstrue from 'cronstrue'
export default {
    props: ['resourceName', 'field'],
    computed: {
        command: function() {
            return this.field.value[0]
        },
        arguments: function() {
            return this.field.value[1] || []
        },
        isJob: function() {
            return !(this.arguments instanceof Array)
        },
        humanArgs: function() {
            if (this.arguments instanceof Array) {
                return this.arguments.join(', ')
            } else {
                return this.arguments
            }

        }
    }
}
</script>
<style scoped>
code {
    color: #c7254e;
    background-color: #f9f2f4;
    border-radius: 4px;
    padding: 2px 4px;
    margin-bottom: 0.5rem;
    display: inline-block;
}
</style>
