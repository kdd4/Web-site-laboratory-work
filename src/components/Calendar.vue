<script setup>
import { ref, toValue, triggerRef, onMounted, watchEffect } from 'vue';

const { show = ref(true) } = defineProps({
	show: Boolean,
});

const date = defineModel({
	default: new Date(Date.now()),
});

const emit = defineEmits(['updateDate', 'selectDate']);

const day_in_week = 7;
const week_cnt = 6;
const day_of_week = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
const months = [
	'Январь',
	'Февраль',
	'Март',
	'Апрель',
	'Май',
	'Июнь',
	'Июль',
	'Август',
	'Сентябрь',
	'Октябрь',
	'Ноябрь',
	'Декабрь',
];

const weeks = ref(new Array(day_in_week * week_cnt));

function updateWeeks() {
	let copyDate = new Date(date.value.getTime());

	copyDate.setDate(1);
	let dayOfWeek = ((copyDate.getDay() + 6) % 7) + 1;

	copyDate.setMonth((copyDate.getMonth() + 1) % 12);
	copyDate.setDate(0);
	let daysInMonth = copyDate.getDate();

	// fill array with 0
	weeks.value.fill(0);

	for (let day = 0; day < daysInMonth; day++) {
		weeks.value[day - 1 + dayOfWeek] = day + 1;
	}
}

watchEffect(updateWeeks);

function addMonth(val) {
	let month = date.value.getMonth() + val;

	let year = date.value.getFullYear();
	if (month > 11) {
		date.value.setFullYear(year + 1);
	} else if (month < 0) {
		date.value.setFullYear(year - 1);
	}
	month = (month + 12) % 12;
	date.value.setMonth(month);

	triggerRef(date); // it's necessary, because of deep of Date type
	emit('updateDate');
}

function addYear(val) {
	let year = date.value.getFullYear() + val;
	date.value.setFullYear(year);

	triggerRef(date); // it's necessary, because of deep of Date type
	emit('updateDate');
}

function getDate(day, week) {
	return weeks.value[day - 1 + (week - 1) * day_in_week];
}

function setDate(day, week) {
	let cur_date = getDate(day, week);

	if (!cur_date) return;

	date.value.setDate(cur_date);

	triggerRef(date); // it's necessary, because of deep of Date type
	emit('updateDate');
}
</script>

<template>
	<div
		v-if="toValue(show)"
		class="max-w-2xl space-y-3 rounded-sm border border-neutral-400/30 bg-neutral-300 p-2"
		v-bind="$attrs"
	>
		<div class="flex justify-between">
			<div>{{ months[date.getMonth()] }} {{ date.getFullYear() }}</div>
			<div class="flex space-x-2 select-none">
				<div @click="addMonth(-1)" class="p-0.5">&lt;</div>
				<div @click="addYear(-1)" class="rotate-90 p-0.5">&gt;</div>
				<div @click="addYear(+1)" class="rotate-90 p-0.5">&lt;</div>
				<div @click="addMonth(1)" class="p-0.5">&gt;</div>
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
			<div v-for="week in week_cnt" :key="week" class="flex space-x-2">
				<div
					v-if="getDate(1, week) || getDate(7, week)"
					v-for="day in day_in_week"
					:key="day"
					:class="{
						'bg-neutral-400/90': getDate(day, week) == date.getDate(),
					}"
					class="w-full rounded-lg bg-neutral-400/30 p-0.5 text-center select-none"
					@click="setDate(day, week)"
					@dblclick="
						setDate(day, week);
						emit('selectDate');
					"
				>
					{{ getDate(day, week) || '' }}
				</div>
			</div>
		</div>
	</div>
</template>
