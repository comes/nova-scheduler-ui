<template>
    <panel-item :field="field">
        <template v-slot:value>
            <code>
                {{ robot }}
            </code>
            <div>
                {{ human }}
            </div>
        </template>
    </panel-item>
</template>

<script>
import cronstrue from "cronstrue"

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
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
