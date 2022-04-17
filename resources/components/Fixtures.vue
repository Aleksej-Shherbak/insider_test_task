<template>
    <div>
        <h1>Matches schedule</h1>
        <p>How many weeks should be calculated:</p>
        <div class="d-flex flex-row mb-1">
            <Counter :max="this.fixtureListLength"></Counter>

            <label class="mx-4" for="matches-number-input">Previous matches number to analyze:</label>
            <input type="number" id="matches-number-input" class=" matches-number-input form-control" min="0">

            <button class="btn btn-sm btn-success mx-2">Start forecasting</button>
        </div>
        <div class="card my-1" v-for="(fixtureList, index) in this.getFixturesLists" :key="index">
            <div class="card-body">
                <h5 class="card-title">Week {{ index + 1 }}</h5>
                <p class="card-text" v-for="fixture in fixtureList" :key="fixture.homeTeamId + fixture.awayTeamId">
                    home: {{ findTeamById(fixture.homeTeamId).name }} vs guest: {{ findTeamById(fixture.awayTeamId).name }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Counter from "./Counter";

export default {
    name: "Fixtures",
    components: {
        Counter
    },
    created() {

    },
    computed: {
        ...mapGetters([
            'getTeams',
            'getFixturesLists'
        ]),
        fixtureListLength: function() {
            return this.getFixturesLists.length;
        }
    },
    methods: {
        ...mapActions([

        ]),
        findTeamById(teamId) {
            return  this.getTeams.find(({ id }) => id === teamId );
        }
    }
}
</script>

<style scoped lang="scss">
    .matches-number-input {
        max-width: 100px;
    }
</style>
