<template>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="building_id">{{ $t('buildings.singular') }}</label>
        <select class="form-control" id="building_id" v-model="values.building_id">
          <option value="" hidden>{{ $t('buildings.select') }}</option>
          <option v-for="building in buildings" :value="building.id">{{ building.name }}</option>
        </select>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row align-items-end">
        <div class="col">
          <div class="form-group">
            <label for="floor">{{ $t('apartments.attributes.floor') }}</label>
            <input type="number" min="0" id="floor" class="form-control" v-model="values.floor">
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input"
                     type="radio"
                     name="has_tenant"
                     v-model="values.has_tenant"
                     id="rented"
                     :value="1">
              <label class="form-check-label" for="rented">
                {{ $t('apartments.rented') }}
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input"
                     type="radio"
                     name="has_tenant"
                     v-model="values.has_tenant"
                     id="all"
                     :value="0">
              <label class="form-check-label" for="all">
                {{ $t('apartments.all') }}
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="apartment_id">{{ $t('apartments.singular') }}</label>
        <input v-if="apartments.length === 0" type="text" class="form-control" :placeholder="$t('apartments.select')" disabled>
        <select v-else class="form-control" v-model="apartment_id" id="apartment_id">
          <option value="" hidden>{{ $t('apartments.select') }}</option>
          <option v-for="apartment in apartments" :value="apartment.id">{{ apartment.name }}</option>
        </select>
        <input type="hidden" name="apartment_id" :value="apartment_id">
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: {

        },
        data() {
            return {
              values: {
                building_id: null,
                has_tenant: 1,
                floor: null,
              },
              apartment_id: null,
              buildings: [],
              apartments: [],
            }
        },
      watch: {
        values: {
          deep: true,
          handler() {
            this.fetchApartments();
          }
        }
      },
        created() {
          axios.get(`/api/buildings`).then(response => this.buildings = response.data.data);
        },
        methods: {
            fetchApartments() {
              axios.get(`/api/apartments`, {params: this.values})
                  .then(response => this.apartments = response.data.data);
            }
        }
    }
</script>

<style>
    .select2-container--bootstrap4.select2-container--focus .select2-selection,
    .select2-container--bootstrap4 .select2-selection{
        display: inline-block !important;
    }
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__rendered {
        display: block !important;
    }
    .select2-result-repository__avatar, .select2-result-repository__meta,
    .select2-selection-result-repository__avatar, .select2-selection-result-repository__meta {
        display: inline-block;
    }

    .select2-result-repository__title, .select2-selection-result-repository__title {
        margin: 0 3px;
    }

    .select2-container[dir=rtl] .select2-selection--single .select2-selection__rendered {
        padding: 0 10px;
    }

    .select2-result-repository__avatar img {
        width: 30px;
        border-radius: 50%;
    }

    .select2-selection-result-repository__avatar img {
        width: 23px;
        border-radius: 50%;
    }

    .select2-container .select2-selection--single {
        height: 34px;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #d2d6de;
        border-radius: 0;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        padding: 2px 0 2px 20px;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
        background: transparent;
        border: 0;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        padding: 0;
        display: flex;
        margin: 5px;
    }
</style>
