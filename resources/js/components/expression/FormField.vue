<template>
    <default-field :field="field" :errors="errors" :show-help-text="showHelpText" class="scheduled-component">
        <template slot="field">
            <span v-text="human"></span>
            <pre><code v-text="robot"></code></pre>

            <div class="flex">
                <button class="btn btn-outline inline-flex items-center"
                        :class="[openTab=='min'?'btn-primary text-white':'']"
                        @click.prevent="openTab='min';fromCron('* * * * *')"><span>Minutes</span></button>
                <button class="btn btn-outline inline-flex items-center"
                        :class="[openTab=='hou'?'btn-primary text-white':'']"
                        @click.prevent="openTab='hou';fromCron('0 8 * * *')"><span>Hourly</span></button>
                <button class="btn btn-outline inline-flex items-center"
                        :class="[openTab=='dai'?'btn-primary text-white':'']"
                        @click.prevent="openTab='dai';fromCron('0 8 * * 1-7')"><span>Daily</span></button>
                <button class="btn btn-outline inline-flex items-center"
                        :class="[openTab=='wee'?'btn-primary text-white':'']"
                        @click.prevent="openTab='wee';fromCron('0 8 * * *')"><span>Weekly</span></button>
                <button class="btn btn-outline inline-flex items-center"
                        :class="[openTab=='mon'?'btn-primary text-white':'']"
                        @click.prevent="openTab='mon';fromCron('0 12 1 * *')"><span>Monthly</span></button>
                <button class="btn btn-outline inline-flex items-center"
                        :class="[openTab=='yea'?'btn-primary text-white':'']"
                        @click.prevent="openTab='yea';fromCron('0 12 1 1 *')"><span>Yearly</span></button>
                <button class="btn btn-outline inline-flex items-center"
                        :class="[openTab=='cus'?'btn-primary text-white':'']"
                        @click.prevent="openTab='cus';fromCron('* * * * *')"><span>Custom</span></button>
            </div>
            <div class="w-full my-0 border border-50 border-2 py-3 px-6">
                <div v-if="openTab == 'cus'">
                    <div class="mb-2">
                        <span>custom in cron notation:</span>
                        <input
                            class="form-control form-input form-input-bordered"
                            type="text"
                            v-model.lazy="robot"
                        />
                    </div>
                </div>
                <div v-else-if="openTab == 'min'" class="flex items-center">
                    <div>
                        <span>Every</span>
                        <select class="border mx-2 px-2 py-1"
                                v-model="buttons.byMinutes"
                                @change.prevent="fromCron($event.target.value)">
                            <option value="* * * * *">1</option>
                            <option value="*/2 * * * *">2</option>
                            <option value="*/3 * * * *">3</option>
                            <option value="*/4 * * * *">4</option>
                            <option value="*/5 * * * *">5</option>
                            <option value="*/6 * * * *">6</option>
                            <option value="*/10 * * * *">10</option>
                            <option value="*/15 * * * *">15</option>
                            <option value="0,20,40 * * * *">20</option>
                            <option value="0,30 * * * *">30</option>
                        </select>
                        <span>minute(s)</span>
                    </div>
                </div>
                <div v-else-if="openTab == 'hou'">
                    <div class="mb-2">
                        <input
                            @click="fromCron('0 * * * *')"
                            type="radio" v-model="option.hou" value="1">
                        <span>Every</span>
                        <select
                            :disabled="option.hou != 1"
                            class="border mx-2 px-2 py-1"
                                v-model="buttons.byHour"
                                @change.prevent="fromCron($event.target.value)">
                            <option value="0 * * * *">1</option>
                            <option value="0 */2 * * *">2</option>
                            <option value="0 */3 * * *">3</option>
                            <option value="0 */4 * * *">4</option>
                            <option value="0 */6 * * *">6</option>
                            <option value="0 */12 * * *">12</option>
                        </select>
                        <span>hour(s)</span>
                    </div>
                    <div class="mb-2">
                        <input
                            @click="fromCron('0 12 * * *')"
                            type="radio"
                            v-model="option.hou"
                            value="2">
                        <span>Starts at</span>
                        <select
                            :disabled="option.hou != 2"
                            class="border mx-2 px-2 py-1"
                            v-model="hours">
                            <option v-for="x of 24"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                        <select
                            :disabled="option.hou != 2"
                            class="border mx-2 px-2 py-1"
                            v-model="minutes">
                            <option v-for="x of 59"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                    </div>

                </div>
                <div v-else-if="openTab == 'dai'">
                    <div>
                        <span>on</span>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="weekdays"
                        >
                            <option :value="[1,2,3,4,5,6,7]">Everyday</option>
                            <option :value="[1,2,3,4,5]">Weekdays</option>

                        </select>
                        <span>
                            at
                        </span>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="hours">
                            <option v-for="x of 24"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="minutes">
                            <option v-for="x of 59"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                    </div>
                </div>
                <div v-else-if="openTab == 'wee'">
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox" v-model="weekdays" value="1">
                            <span class="ml-1 mr-2 mt-1">Monday</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox" v-model="weekdays" value="2">
                            <span class="ml-1 mr-2 mt-1">Tuesday</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox" v-model="weekdays" value="3">
                            <span class="ml-1 mr-2 mt-1">Wednesday</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox" v-model="weekdays" value="4">
                            <span class="ml-1 mr-2 mt-1">Thursday</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox" v-model="weekdays" value="5">
                            <span class="ml-1 mr-2 mt-1">Friday</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox" v-model="weekdays" value="6">
                            <span class="ml-1 mr-2 mt-1">Saturday</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox" v-model="weekdays" value="7">
                            <span class="ml-1 mr-2 mt-1">Sunday</span>
                        </label>
                    </div>
                    <div class="mb-2">
                        <span>
                            Starts at
                        </span>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="hours">
                            <option v-for="x of 24"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="minutes">
                            <option v-for="x of 59"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                    </div>
                </div>
                <div v-else-if="openTab == 'mon'">
                    <div class="mb-2">
                        <input type="radio" v-model="option.mon" value="1">
                        <span>At day</span>
                        <select
                            :disabled="option.mon != 1"
                            class="border mx-2 px-2 py-1"
                            v-model="days">
                            <option
                                v-for="x in 31"
                                :value="[x]">
                                {{ x }}
                            </option>
                        </select>
                        <span>of every</span>
                        <select
                            :disabled="option.mon != 1"
                            class="border mx-2 px-2 py-1"
                            v-model="months"
                        >
                            <option :value="[1,2,3,4,5,6,7,8,9,10,11,12]">1</option>
                            <option :value="[1,3,5,7,9,11]">2</option>
                            <option :value="[1,4,7,10]">3</option>
                            <option :value="[1,5,9]">4</option>
                            <option :value="[1,7]">6</option>
                        </select>
                        <span>month</span>
                    </div>
                    <div class="mb-2">
                        <input type="radio" v-model="option.mon" value="2">
                        <span>The</span>
                        <select
                            :disabled="option.mon != 2"
                            class="border mx-2 px-2 py-1"
                            v-model="days">
                            <option :value="[1,2,3,4,5,6,7]">First</option>
                            <option :value="[8,9,10,11,12,13,14,15]">Second</option>
                            <option :value="[16,17,18,19,20,21,22,23]">Third</option>
                            <option :value="[24,25,26,27,28,29,30,31]">Fourth</option>
                        </select>
                        <select
                            :disabled="option.mon != 2"
                            class="border mx-2 px-2 py-1"
                            v-model="weekdays">
                            <option :value="[1]">Monday</option>
                            <option :value="[2]">Tuesday</option>
                            <option :value="[3]">Wednesday</option>
                            <option :value="[4]">Thursday</option>
                            <option :value="[5]">Friday</option>
                            <option :value="[6]">Saturday</option>
                            <option :value="[7]">Sunday</option>
                        </select>
                        <span>of every</span>
                        <select
                            :disabled="option.mon != 2"
                            class="border mx-2 px-2 py-1"
                            v-model="months"
                        >
                            <option :value="[1,2,3,4,5,6,7,8,9,10,11,12]">1</option>
                            <option :value="[1,3,5,7,9,11]">2</option>
                            <option :value="[1,4,7,10]">3</option>
                            <option :value="[1,5,9]">4</option>
                            <option :value="[1,7]">6</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <span>
                            Starts at
                        </span>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="hours">
                            <option v-for="x of 24"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="minutes">
                            <option v-for="x of 59"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                    </div>
                </div>
                <div v-else-if="openTab == 'yea'">
                    <div class="mb-2">
                        <input type="radio" v-model="option.yea" value="1">
                        <span>Every</span>
                        <select
                            :disabled="option.yea != '1'"
                            class="border mx-2 px-2 py-1"
                            v-model="months"
                        >
                            <option :value="[1]">
                                January
                            </option>
                            <option :value="[2]">
                                February
                            </option>
                            <option :value="[3]">
                                March
                            </option>
                            <option :value="[4]">
                                April
                            </option>
                            <option :value="[5]">
                                May
                            </option>
                            <option :value="[6]">
                                June
                            </option>
                            <option :value="[7]">
                                July
                            </option>
                            <option :value="[8]">
                                August
                            </option>
                            <option :value="[9]">
                                September
                            </option>
                            <option :value="[10]">
                                October
                            </option>
                            <option :value="[11]">
                                November
                            </option>
                            <option :value="[12]">
                                December
                            </option>
                        </select>
                        <select
                            :disabled="option.yea != '1'"
                            class="border mx-2 px-2 py-1"
                            v-model="days">
                            <option
                                v-for="x in 31"
                                :value="[x]">
                                {{ x }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <input type="radio" v-model="option.yea" value="2">
                        <span>The</span>
                        <select
                            :disabled="option.yea != '2'"
                            class="border mx-2 px-2 py-1"
                            v-model="days">
                            <option :value="[1,2,3,4,5,6,7]">First</option>
                            <option :value="[8,9,10,11,12,13,14,15]">Second</option>
                            <option :value="[16,17,18,19,20,21,22,23]">Third</option>
                            <option :value="[24,25,26,27,28,29,30,31]">Fourth</option>
                        </select>
                        <select
                            :disabled="option.yea != '2'"
                            class="border mx-2 px-2 py-1"
                            v-model="weekdays">
                            <option :value="[1]">Monday</option>
                            <option :value="[2]">Tuesday</option>
                            <option :value="[3]">Wednesday</option>
                            <option :value="[4]">Thursday</option>
                            <option :value="[5]">Friday</option>
                            <option :value="[6]">Saturday</option>
                            <option :value="[7]">Sunday</option>
                        </select>
                        <span>of</span>
                        <select
                            :disabled="option.yea != '2'"
                            class="border mx-2 px-2 py-1"
                            v-model="months"
                        >
                            <option :value="[1]">
                                January
                            </option>
                            <option :value="[2]">
                                February
                            </option>
                            <option :value="[3]">
                                March
                            </option>
                            <option :value="[4]">
                                April
                            </option>
                            <option :value="[5]">
                                May
                            </option>
                            <option :value="[6]">
                                June
                            </option>
                            <option :value="[7]">
                                July
                            </option>
                            <option :value="[8]">
                                August
                            </option>
                            <option :value="[9]">
                                September
                            </option>
                            <option :value="[10]">
                                October
                            </option>
                            <option :value="[11]">
                                November
                            </option>
                            <option :value="[12]">
                                December
                            </option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <span>
                            Starts at
                        </span>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="hours">
                            <option v-for="x of 24"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                        <select
                            class="border mx-2 px-2 py-1"
                            v-model="minutes">
                            <option v-for="x of 59"
                                    :value="[x - 1]"> {{ x - 1 }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </template>
    </default-field>
</template>

<script>

import {FormField, HandlesValidationErrors} from 'laravel-nova'

const cronParser = require('cron-parser')
import cronstrue from "cronstrue/i18n"

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data: () => ({
        buttons: {
            byMinutes: '* * * * *',
            byHour: '0 * * * *',
        },
        interval: {
            fields: []
        },
        days: [],
        hours: [],
        minutes: [],
        months: [],
        weekdays: [],
        openTab : 'cus',
        option: {
            yea: 1,
            mon: 1,
            dai: 1,
            hou: 1,
        }
    }),
    computed: {
        human: function() {
            return cronstrue.toString(this.robot, { locale: "de" })
        },
        robot: {
            get: function() {
                try {
                    return this.cronString()
                } catch (e) {
                    return '* * * * *'
                }
            },
            set: function(newValue) {
                this.fromCron(newValue)
            }
        }
    },

    methods: {
        fromCron(cron) {
            let interval = cronParser.parseExpression(cron)
            this.days = interval.fields.dayOfMonth || []
            this.hours = interval.fields.hour || []
            this.minutes = interval.fields.minute || []
            this.months = interval.fields.month || []
            this.weekdays = interval.fields.dayOfWeek || []
        },
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            if (this.field.hasOwnProperty('event')) {
                let interval = this.interval = cronParser.parseExpression(this.field.event.expression)
                this.days = interval.fields.dayOfMonth || []
                this.hours = interval.fields.hour || []
                this.minutes = interval.fields.minute || []
                this.months = interval.fields.month || []
                this.weekdays = interval.fields.dayOfWeek || []

                this.value = this.field.event.expression || ''
            } else {
                this.value = ''
            }

            this.value = this.field.value || ''
        },

        ArrWrap(v) {
            if (!v instanceof Array) {
                v = ['' + v]
            }

            return v
        },

        cronString() {
            // formData.append(this.field.attribute, this.value || '')
            let interval = cronParser.parseExpression('* * * * *')
            let fields = JSON.parse(JSON.stringify(interval.fields))


            fields.hour = Array.from(this.ArrWrap(this.hours) || []).map(v => parseInt(v))
            fields.minute = Array.from(this.ArrWrap(this.minutes) || []).map(v => parseInt(v))
            fields.dayOfMonth = Array.from(this.ArrWrap(this.days) || []).map(v => parseInt(v))
            fields.month = Array.from(this.ArrWrap(this.months) || []).map(v => parseInt(v))
            fields.dayOfWeek = Array.from(this.ArrWrap(this.weekdays) || []).map(v => parseInt(v))

            let modifiedInterval = cronParser.fieldsToExpression(fields);
            let value = modifiedInterval.stringify();

            return value
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.cronString() || '')
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
