<template>
    <span v-text="human"></span>
</template>

<script>
import cronstrue from 'cronstrue'
export default {
    props: ['resourceName', 'field'],
    computed: {
        robot: function() {
            return this.field.event.expression || '* * * * *'
        },
        human: function() {
            return cronstrue.toString(this.robot);
        }
    }
}
</script>
