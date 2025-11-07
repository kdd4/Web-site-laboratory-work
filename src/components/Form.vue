<script setup>
import { toValue } from 'vue';

const { fields = [], formdata = {} } = defineProps({
	fields: Object,
	formdata: Object,
});

const { allowSubmit = true, reset = false } = formdata;

defineEmits(['submit', 'reset']);
</script>

<template>
	<form
		class="flex flex-col space-y-3 rounded-lg border-2 border-neutral-400/30 bg-neutral-300 p-2"
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
				<label v-if="field.label !== undefined" class="mr-1 whitespace-nowrap"
					>{{ field.label }}:</label
				>
				<input
					v-if="field.type == 'text'"
					type="text"
					:name="field.name"
					:placeholder="field.placeholder"
					v-model.trim.lazy="field.var_ref"
					:class="{ 'bg-red-400': field.wrongValue_ref }"
					class="w-full rounded-sm border border-neutral-400 bg-neutral-400/30"
				/>

				<div
					v-if="field.type == 'radio'"
					:class="{ 'bg-red-400': field.wrongValue_ref }"
					class="flex w-full justify-evenly space-x-3 rounded-sm"
				>
					<div v-for="(option, opt_ind) in field.options" :key="opt_ind">
						<label v-if="option.text !== undefined" v-html="option.text"></label>
						<input
							type="radio"
							:name="field.name"
							:value="option.value"
							v-model="field.var_ref"
							class="accent-purple-500"
						/>
					</div>
				</div>

				<select
					v-if="field.type == 'select'"
					:name="field.name"
					v-model="field.var_ref"
					:class="{ 'bg-red-400': field.wrongValue_ref }"
					class="rounded-sm border border-neutral-400 bg-neutral-400/30"
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
</template>
