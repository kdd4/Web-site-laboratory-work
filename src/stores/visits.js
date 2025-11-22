import { defineStore } from 'pinia';
import { ref, watch } from 'vue';

export const useVisitsStore = defineStore('visits', () => {
	const visits = ref({});
	const visitsSession = ref({});

	function loadVisits() {
		try {
			const match = document.cookie.match(/visits=(?<json>.+?)(?:;|$)/);
			let json_visits = match.groups.json;

			if (!json_visits) return;

			visits.value = JSON.parse(decodeURIComponent(json_visits));
		} catch (error) {
			console.warn('Visits in cookie getting error');
			console.warn(error);

			visits.value = {};
		}
	}

	function loadVisitsSession() {
		let json_visitsSession = localStorage.visits;

		if (!json_visitsSession) return;

		try {
			visitsSession.value = JSON.parse(decodeURIComponent(json_visitsSession));
		} catch (error) {
			console.warn('Session visits in localstorege getting error');
			console.warn(error);

			visitsSession.value = {};
		}
	}

	function saveVisits() {
		let expiresDate = new Date(Date.now());
		let curDate = expiresDate.getDate();

		expiresDate.setDate(curDate + 7);

		let expires = expiresDate.toUTCString();

		try {
			let json_visits = JSON.stringify(visits.value);
			let json_visitsSession = JSON.stringify(visitsSession.value);

			localStorage.visits = encodeURIComponent(json_visitsSession);
			document.cookie = `visits=${encodeURIComponent(json_visits)}; path=/; samesite=strict; expires=${expires}`;
		} catch (error) {
			console.warn('Saving visits error');
			console.error(error);
		}
	}

	function visitPage(name) {
		let visitCnt = visits.value[name];
		let sessionVisitCnt = visitsSession.value[name];

		if (visitCnt === undefined) visitCnt = 0;
		if (sessionVisitCnt === undefined) sessionVisitCnt = 0;

		visits.value[name] = visitCnt + 1;
		visitsSession.value[name] = sessionVisitCnt + 1;
	}

	function getVisits(name) {
		let visitCnt = visits.value[name];

		if (visitCnt === undefined) visitCnt = 0;

		return visitCnt;
	}

	function getVisitsSession(name) {
		let sessionVisitCnt = visitsSession.value[name];

		if (sessionVisitCnt === undefined) sessionVisitCnt = 0;

		return sessionVisitCnt;
	}

	loadVisits();
	loadVisitsSession();

	// .value нужен, так как на реактивных объектах
	// автоматчески устанавливаются глубокие наблюдатели
	watch([visits.value, visitsSession.value], saveVisits);

	return { visitPage, getVisits, getVisitsSession };
});
