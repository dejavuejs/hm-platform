@extends('admin::layouts.content')

@section('page_title')
    {{ __('plans::app.subs-manage') }}
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- @if ($existing->count() && $existing->first()->base !== $existing->first()->current)
            <button class="btn btn-lg btn-primary" @click="revertToBaseDomain()">Revert to base</button>
        @endif --}}

        <domain-changer></domain-changer>
    </div>
    <!-- end row-->
</div>
@endsection

@push('scripts')
    <script type="text/x-template" id="domain-changer">
        <div class="col-12">
            <form action="{{ route('company.domain.store') }}" method="POST" @submit.prevent="onSubmit">
                @csrf

                <div class="step-1 mb-30">
                    <h1 id="display-title-tour">Step 1</h1>

                    <p class="text-bold">
                        <ul>
                            <li>
                                Create a new <b>'CNAME'</b> entry.
                            </li>

                            <li class="mt-10">
                                NAME or HOST = <b>'thisismystore.something'</b>.
                            </li>

                            <li class="mt-10">
                                Points to <b>'cname.bryg.io'</b>
                            </li>
                        </ul>
                    </p>

                    <div class="row control-group" :class="[errors.has('step_1') ? 'has-error' : '']" style="width: max-content">
                        <label style="width:100%">Step one complete</label>

                        <input class="checkbox" type="checkbox" v-validate="'required'" name="step_1" v-model="step_1">

                        <span class="control-error" v-if="errors.has('step_1')">@{{ errors.first('step_1') }}</span>
                    </div>
                </div>

                <div class="step-2" v-if="step_1">
                    <h1 id="display-title-tour">Step 2</h1>

                    <input type="hidden" name="old_domain" v-model="old_domain">

                    <div class="control-group">
                        <label>{{ \Company::getCurrent()->domain }}</label>
                    </div>

                    <div class="control-group" :class="[errors.has('new_domain') ? 'has-error' : '']">
                        <label>Enter new domain (without https:// or http://, ex -> avansaber.com)</label>

                        <input type="text" class="control" name="new_domain" v-model="new_domain" v-validate="'url|required'" data-vv-as="New domain">

                        <span class="control-error" v-if="errors.has('new_domain')">@{{ errors.first('new_domain') }}</span>
                    </div>
                </div>

                <div class="step-3" v-if="this.$validator.errors.count() == 0 && new_domain !== null">
                    <input type="hidden" name="channel_id" v-model="channel_id">

                    <input type="submit" class="btn btn-md btn-primary" value="Change domain">
                </div>
            </form>
        </div> <!-- end col -->
    </script>

    <script>
        Vue.component('domain-changer', {
            template: '#domain-changer',

            inject: ['$validator'],

            data: function() {
                return {
                    step_1: 0,
                    new_domain: null,
                    old_domain: '{{ \Company::getCurrent()->domain }}',
                    channel_id: '{{ core()->getCurrentChannel()->id }}',
                }
            },

            // watch: {
            //     new_domain: function(value) {
            //         console.log(this.$validator.errors.count());
            //     }
            // },

            methods: {
                onSubmit: function(e) {
                    this_this = this;

                    axios.post('{{ route('company.domain.store') }}', {
                        step_1: this.step_1,
                        new_domain: this.new_domain,
                        old_domain: this.old_domain,
                        channel_id: this.channel_id
                    }).then(function(result) {
                        window.flashMessages = [{'type': 'alert-success', 'message': result.data.message}];

                        this_this.$root.addFlashMessages();

                        alert('Domain changed, please open your new domain in another window');
                    }).catch(function(errors) {
                        window.serverErrors = errors.response.data.errors;
                        console.log(window.serverErrors);
                        for (i in window.serverErrors) {
                            window.flashMessages = [{'type': 'alert-error', 'message': serverErrors[i][0]}];

                            const field = this_this.$validator.fields.find({
                                name: i,
                                scope: null
                            });

                            this_this.$validator.errors.add({
                                // id: field.id,
                                field: i,
                                msg: serverErrors[i][0],
                                scope: null
                            });
                        }

                        this_this.$root.addFlashMessages();
                    });
                }
            }
        });
    </script>
@endpush