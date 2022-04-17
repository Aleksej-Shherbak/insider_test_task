<template>
    <div>
        <h1>Matches schedule</h1>
        <p>Previous matches number to analyze:</p>
        <div class="d-flex flex-row mb-1">
            <Counter @countChanged="countChangedHandler" :min="10" :max="this.roundsNumbers"></Counter>
            <button @click="fetchForecasts" class="btn btn-sm btn-success mx-2">Start forecasting</button>
        </div>
        <div class="card my-1" v-for="(round, index) in this.getRounds" :key="index">
            <div class="card-body">
                <h5 class="card-title">Week {{ index + 1 }}</h5>
                <div  v-for="fixture in round.fixtures" :key="fixture.homeTeamId + fixture.guestTeamId">
                    <p class="card-text">
                        home: {{ findTeamById(fixture.homeTeamId).name }}
                        <span v-if="fixture.homeTeamWinProbability">(with win probability: {{ fixture.homeTeamWinProbability * 100 }}%) </span>
                        vs
                        guest: {{ findTeamById(fixture.guestTeamId).name }}
                        <span v-if="fixture.guestTeamWinProbability">(with win probability: {{ fixture.guestTeamWinProbability * 100 }}%) </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import Counter from "./Counter";
import backendUrls from "../js/backendUrls";

export default {
    name: "Fixtures",
    components: {
        Counter
    },
    created() {
    },
    data() {
        return {
            matchesLookBackCount: 10,
        }
    },
    computed: {
        ...mapGetters([
            'getTeams',
            'getRounds'
        ]),
        roundsNumbers: function() {
            return this.getRounds.length;
        }
    },
    methods: {
        ...mapMutations([
            'setRounds'
        ]),
        countChangedHandler(value) {
            this.matchesLookBackCount = value;
        },
        findTeamById(teamId) {
            return this.getTeams.find(({ id }) => id === teamId );
        },
        async fetchForecasts() {
            let response = await window.axios.post(`${backendUrls.base}/${backendUrls.forecast.getForecast}`, {
                rounds: this.getRounds,
                matches_look_back_count: this.matchesLookBackCount
            });

            this.setRounds(response.data);
        },
    }
}
</script>

<style scoped lang="scss">
    .matches-number-input {
        max-width: 100px;
    }
</style>
