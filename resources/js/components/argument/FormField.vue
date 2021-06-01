<template>
    <default-field :field="field" :errors="errors" :show-help-text="showHelpText" class="scheduled-component">
        <template slot="field">
            <div class="mb-2">
                <label for="isJob">
                    <input type="checkbox"
                           class="checkbox"
                           :class="errorClasses"
                           @change="toggleArg"
                           v-model="isJob"
                           id="isJob">
                    Handle as Job?
                </label>
            </div>
            <div class="flex items-center mb-2">
                <label for="command" class="w-1/5">
                    <span v-if="isJob">{{ __('Job') }}</span>
                    <span v-else>{{ __('Command') }}</span>
                </label>
                <input
                    id="command"
                    type="text"
                    class="w-1/2 form-control form-input form-input-bordered"
                    :class="errorClasses"
                    v-model="custom.command">
            </div>
            <div v-if="!isJob" class="w-full">
                <div
                    class="flex items-center"
                    v-for="(argument,idx) in custom.arguments"
                     :key="'args-' + idx">
                    <label
                        class="w-1/5"
                        :for="'argument-' + idx">
                        Argument {{ idx + 1 }}
                    </label>
                    <input
                        type="text"
                        class="w-1/2 form-control form-input form-input-bordered"
                        :class="errorClasses"
                        v-model="custom.arguments[idx]"
                    >
                </div>
                <div>
                    <button
                        class="btn btn-default btn-primary"
                        @click.prevent="custom.arguments.push('')">new Argument</button>
                </div>
            </div>
            <div v-else
                 class="flex items-center">
                <label
                    class="w-1/5"
                    for="argument-queue">
                    Queue
                </label>
                <input
                    id="argument-queue"
                    type="text"
                    class="w-1/2 form-control form-input form-input-bordered"
                    :class="errorClasses"
                    v-model="custom.queue"
                >
            </div>
        </template>
    </default-field>
</template>

<script>

import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data: () => ({
        custom: {
            command: '',
            arguments: [],
            queue: 'default'
        },
        isJob : false,
    }),
    computed: {
        command: function() {
            return this.field.value[0]
        },
        arguments: function() {
            return this.field.value[1] || []
        },
        humanArgs: function() {
            if (this.arguments instanceof Array) {
                return this.arguments.join(', ')
            } else {
                return this.arguments
            }

        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.isJob =  !(this.arguments instanceof Array)
            if (this.isJob) {
                this.custom.queue = this.field.value[1] || ''
            } else {
                this.custom.arguments = this.field.value[1] || []
            }

            this.custom.command = this.command

        },

        ArrWrap(v) {
            if (!v instanceof Array) {
                v = ['' + v]
            }

            return v
        },
        fill(formData) {
            if (this.isJob) {
                formData.append(this.field.attribute, JSON.stringify([this.custom.command, this.custom.queue]))
            } else {
                formData.append(this.field.attribute, JSON.stringify([this.custom.command, this.custom.arguments]))
            }

        },
    },
}
</script>
<style >
    pre code {
        color: #c7254e;
        background-color: #f9f2f4;
        border-radius: 4px;
        padding: 2px 4px;
        margin-bottom: 0.5rem;
        display: inline-block;
    }
    .scheduled-component > .w-1\/2 {
        width: 80% !important;
    }
</style>
