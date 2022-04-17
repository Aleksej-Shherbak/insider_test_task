<template>
    <div>
        <h1>Teams</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(team, index) in this.getTeams"
                :key="team.id"
                :class="selectedTeamIds.includes(team.id) ? 'bg-dark text-light' : 'text-secondary'"
                @click="select(team.id)">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ team.name }}</td>
            </tr>
            </tbody>
        </table>

        <button
            class="btn btn-primary "
            :disabled="!submitAvailable"
            @click="calculateFixtures">
            Generate fixtures
        </button>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    name: "Teams",
    data() {
        return {
            selectedTeamIds: [],
        }
    },
    created() {
        return this.fetchAllTeams();
    },
    computed: {
        ...mapGetters([
            'getTeams',
        ]),
        submitAvailable: function() {
            return  this.selectedTeamIds.length > 0 && this.selectedTeamIds.length % 2 === 0;
        }
    },
    methods: {
        ...mapActions([
            'fetchAllTeams',
            'fetchFixturesForSelectedTeams',
        ]),
        select(teamId) {
            if (this.selectedTeamIds.includes(teamId)) {
                this.selectedTeamIds = this.selectedTeamIds.filter(x => x !== teamId);
                return;
            }
            this.selectedTeamIds.push(teamId);
        },
        async calculateFixtures() {
            await this.fetchFixturesForSelectedTeams(this.selectedTeamIds);
            await this.$router.push({name: 'fixtures'});
        }
    }
}
</script>

<style scoped lang="scss">
.table {
    tr {
        cursor: pointer;
    }
}
</style>
