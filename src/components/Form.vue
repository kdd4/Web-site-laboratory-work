<script setup>
import { ref, toValue, watch } from 'vue';
import Calendar from '@/components/Calendar.vue';

const { fields = [], formdata = {} } = defineProps({
	fields: Object,
	formdata: Object,
});

const { allowSubmit = true, reset = false } = formdata;

defineEmits(['submit', 'reset']);

const showCalendar = ref(false);
const dateCalendar = ref(new Date(Date.now()));
let watchCalendar = null;

function useCalendar(field) {
	if (watchCalendar) {
		watchCalendar.stop();
		watchCalendar = null;
	}

	if (showCalendar.value) {
		showCalendar.value = false;
		return;
	}

	watchCalendar = watch(dateCalendar, () => (field.fieldValue = dateCalendar.value));

	showCalendar.value = true;
}

function closeCalendar() {
	if (watchCalendar) {
		watchCalendar.stop();
		watchCalendar = null;
	}

	if (showCalendar.value) showCalendar.value = false;
}
</script>

<template>
	<form
		class="flex flex-col space-y-3 rounded-lg border-2 border-neutral-400/30 bg-neutral-300 p-2 py-3"
		action=""
		method="Post"
		enctype="text/plain"
		v-bind="$attrs"
		@submit.prevent="$emit('submit')"
		@reset.prevent="$emit('reset')"
	>
		<div
			v-for="(field, ind) in fields"
			:key="ind"
			:class="{ 'rounded-sm bg-neutral-400/30 p-2': field.header !== undefined }"
		>
			<h3 v-if="field.header !== undefined">{{ field.header }}</h3>
			<p v-if="field.text !== undefined" class="mb-3">{{ field.text }}</p>
			<div class="flex">
				<label v-if="field.label !== undefined" class="mr-1 whitespace-nowrap select-none"
					>{{ field.label }}:</label
				>

				<!--Type text-->
				<input
					v-if="field.type == 'text'"
					type="text"
					:name="field.name"
					:placeholder="field.placeholder"
					v-model.trim.lazy="field.fieldValue"
					:class="{
						'bg-neutral-400/30': !field.hasError && !field.isCorrect,
						'bg-green-400': field.isCorrect && !field.hasError,
						'bg-red-400': field.hasError,
					}"
					class="w-full rounded-sm border border-neutral-400"
					@click="closeCalendar"
				/>

				<!--Type radio-->
				<div
					v-if="field.type == 'radio'"
					:class="{
						'bg-green-400': field.isCorrect && !field.hasError,
						'bg-red-400': field.hasError,
					}"
					class="flex w-full justify-evenly space-x-3 rounded-sm"
				>
					<div v-for="(option, opt_ind) in field.options" :key="opt_ind">
						<label
							v-if="option.text !== undefined"
							v-html="option.text"
							class="select-none"
						></label>
						<input
							type="radio"
							:name="field.name"
							:value="option.value"
							v-model="field.fieldValue"
							class="accent-purple-500"
							@click="closeCalendar"
						/>
					</div>
				</div>

				<!--Type select-->
				<select
					v-if="field.type == 'select'"
					:name="field.name"
					v-model="field.fieldValue"
					:class="{
						'bg-neutral-400/30': !field.hasError && !field.isCorrect,
						'bg-red-400': field.hasError,
						'bg-green-400': field.isCorrect && !field.hasError,
					}"
					class="rounded-sm border border-neutral-400"
					@click="closeCalendar"
				>
					<option
						v-if="field.options !== undefined"
						v-for="(option, sel_ind) in field.options"
						:key="sel_ind"
						:disabled="option.disabled"
						:value="option.value"
					>
						{{ option.text }}
					</option>
				</select>

				<!--Type date-->
				<div
					v-if="field.type == 'date'"
					:class="{
						'bg-neutral-400/30': !field.hasError && !field.isCorrect,
						'bg-red-400': field.hasError,
						'bg-green-400': field.isCorrect && !field.hasError,
					}"
					class="w-full rounded-sm border border-neutral-400 text-center"
					@click="useCalendar(field)"
				>
					<input type="hidden" :name="field.name" v-model="field.fieldValue" />
					{{ (field.fieldValue.getDate() + '').padStart(2, '0') }}.{{
						(field.fieldValue.getMonth() + 1 + '').padStart(2, '0')
					}}.{{ field.fieldValue.getFullYear() }}
				</div>
			</div>
		</div>
		<div class="flex items-baseline justify-evenly">
			<input
				:disabled="!toValue(allowSubmit)"
				type="submit"
				:class="{
					'cursor-not-allowed text-neutral-500': !toValue(allowSubmit),
					'cursor-pointer': toValue(allowSubmit),
				}"
				class="w-min self-center rounded-sm border border-neutral-400 bg-neutral-400/30 px-1"
			/>
			<input
				v-if="reset"
				type="reset"
				class="w-min cursor-pointer self-center rounded-sm border border-neutral-400 bg-neutral-400/30 px-1"
			/>
		</div>
	</form>
	<Calendar
		:show="showCalendar"
		v-model="dateCalendar"
		@updateDate="dateCalendar = new Date(dateCalendar)"
		@selectDate="closeCalendar"
	/>
</template>
