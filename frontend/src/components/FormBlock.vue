<script setup>
import { storeToRefs } from 'pinia';
import { ref, toRefs } from 'vue';

import { useFormCalendar } from '@/stores/formCalendar';

import Calendar from '@/components/CalendarBlock.vue';

const { fields = ref([]), formdata = ref({}) } = defineProps({
	fields: Object,
	formdata: Object,
});

const {
	allowSubmit = ref(true),
	submitText = ref(undefined),
	reset = ref(false),
} = toRefs(formdata);

defineEmits(['submit', 'reset']);

const formCalendarStore = useFormCalendar();

const { calendarDate } = storeToRefs(formCalendarStore);
const { useCalendar, closeCalendar } = formCalendarStore;

function ChangeFile(event, field) {
	if (field.change instanceof Function) {
		field.change(event.target.files);
	}

	if (event.target.files.length != 0) {
		field.filename = event.target.files[0].name;
	} else {
		field.filename = undefined;
	}
}
</script>

<template>
	<form
		class="flex flex-col space-y-3 rounded-lg border-2 border-neutral-400/30 bg-neutral-300 p-2 py-3"
		enctype="multipart/form-data"
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

				<!--Type button-->
				<button
					v-if="field.type == 'button'"
					v-html="field.buttonText"
					@click.prevent="field.click"
					class="w-full rounded-sm border border-neutral-400"
				></button>

				<!--Type text-->
				<input
					v-if="field.type == 'text' || field.type == 'password'"
					:type="field.type"
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

				<!--Type textarea-->
				<textarea
					v-if="field.type == 'textarea'"
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
				></textarea>

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
					v-if="field.type == 'select' && field.options !== undefined"
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
						v-for="(option, sel_ind) in field.options"
						:key="sel_ind"
						:disabled="option.disabled"
						:value="option.value"
					>
						{{ option.text }}
					</option>
				</select>

				<!--Type file-->
				<div
					v-if="field.type == 'file'"
					:class="{
						'bg-neutral-400/30': !field.hasError && !field.isCorrect,
						'bg-green-400': field.isCorrect && !field.hasError,
						'bg-red-400': field.hasError,
					}"
					@click="closeCalendar"
				>
					<label
						:for="($attrs['id'] ?? 'form') + '_' + field.name"
						class="w-full rounded-sm border border-neutral-400"
					>
						{{ field.filename ?? 'Выберите файл' }}
					</label>
					<input
						:id="($attrs['id'] ?? 'form') + '_' + field.name"
						type="file"
						:name="field.name"
						:accept="field.accept"
						hidden="true"
						@change="(e) => ChangeFile(e, field)"
					/>
				</div>

				<!--Type date-->
				<div
					v-if="field.type == 'date'"
					:class="{
						'bg-neutral-400/30': !field.hasError && !field.isCorrect,
						'bg-red-400': field.hasError,
						'bg-green-400': field.isCorrect && !field.hasError,
					}"
					class="w-full rounded-sm border border-neutral-400 text-center select-none"
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
				:disabled="!allowSubmit"
				type="submit"
				:class="{
					'cursor-not-allowed text-neutral-500': !allowSubmit,
					'cursor-pointer': allowSubmit,
				}"
				class="w-min self-center rounded-sm border border-neutral-400 bg-neutral-400/30 px-1"
				:value="submitText"
			/>
			<input
				v-if="reset"
				type="reset"
				class="w-min cursor-pointer self-center rounded-sm border border-neutral-400 bg-neutral-400/30 px-1"
			/>
		</div>
	</form>
	<Calendar :calendarDate="calendarDate" @selectDate="closeCalendar" />
</template>
