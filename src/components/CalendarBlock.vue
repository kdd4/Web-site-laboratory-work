<script setup>
import { ref, watchEffect, toRefs } from 'vue';
import { useCalendarStore } from '@/stores/calendar';
import { useDatesStore } from '@/stores/dates';

const calendarStore = useCalendarStore();
const datesStore = useDatesStore();

const { updateWeeks, getDate, addMonth, addYear, setDate } = calendarStore;
const { day_in_week, week_cnt, day_of_week, months } = datesStore;

const { calendarDate = {} } = defineProps({
	calendarDate: Object,
});

const emit = defineEmits(['selectDate']);

const { show = ref(true), date = ref(new Date(Date.now())) } = toRefs(calendarDate);

watchEffect(() => updateWeeks(date.value));
</script>

<template>
	<div
		v-if="show"
		class="max-w-2xl space-y-3 rounded-sm border border-neutral-400/30 bg-neutral-300 p-2"
		v-bind="$attrs"
	>
		<div class="flex justify-between">
			<div>{{ months[date.getMonth()] }} {{ date.getFullYear() }}</div>
			<div class="flex space-x-2 select-none">
				<div @click="date = addMonth(date, -1)" class="p-0.5">&lt;</div>
				<div @click="date = addYear(date, -1)" class="rotate-90 p-0.5">&gt;</div>
				<div @click="date = addYear(date, 1)" class="rotate-90 p-0.5">&lt;</div>
				<div @click="date = addMonth(date, 1)" class="p-0.5">&gt;</div>
			</div>
		</div>
		<div class="space-y-2">
			<div class="flex space-x-2">
				<div
					v-for="(day, ind) in day_of_week"
					:key="ind"
					class="mb-1 w-full rounded-lg bg-neutral-400/30 p-0.5 text-center select-none"
				>
					{{ day }}
				</div>
			</div>
			<div v-for="week in week_cnt" :key="week" class="flex">
				<div v-if="getDate(1, week) || getDate(7, week)" class="contents space-x-2">
					<div
						v-for="day in day_in_week"
						:key="day"
						:class="{
							'bg-neutral-400/90': getDate(day, week) == date.getDate(),
						}"
						class="w-full rounded-lg bg-neutral-400/30 p-0.5 text-center select-none"
						@click="date = setDate(date, day, week)"
						@dblclick="emit('selectDate')"
					>
						{{ getDate(day, week) || '' }}
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
