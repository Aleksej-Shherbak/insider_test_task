<template>
    <div>
        <h1>Matches schedule</h1>
        <p>Previous matches number to analyze:</p>
        <div class="d-flex flex-row mb-1">
            <Counter @countChanged="countChangedHandler" :min="10" :max="this.roundsNumbers"></Counter>
            <button @click="getForecast" class="btn btn-sm btn-success mx-2">Start forecasting</button>
        </div>
        <div class="card my-1" v-for="(round, index) in this.getRounds" :key="index">
            <div class="card-body">
                <h5 class="card-title">Week {{ index + 1 }}</h5>
                <p class="card-text" v-for="fixture in round.fixtures" :key="fixture.homeTeamId + fixture.awayTeamId">
                    home: {{ findTeamById(fixture.homeTeamId).name }} vs guest: {{ findTeamById(fixture.awayTeamId).name }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
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
            matchesLookBackCount: 10
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
        countChangedHandler(value) {

        },
        findTeamById(teamId) {
            return this.getTeams.find(({ id }) => id === teamId );
        },
        async getForecast() {
            await window.axios.post(`${backendUrls.base}/${backendUrls.forecast.getForecast}`, {
                rounds: this.getRounds,
                matches_look_back_count: this.matchesLookBackCount
            })
        }
    }
}
</script>

<style scoped lang="scss">
    .matches-number-input {
        max-width: 100px;
    }
</style>
