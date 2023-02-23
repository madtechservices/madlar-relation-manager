<?php

use \TomatoPHP\TomatoRelationManager\View\Components\RelationManager;


?>
<div aria-hidden="true" class="filament-hr border-t dark:border-gray-700"></div>
<div class="filament-resources-relation-managers-container space-y-2">

    <x-splade-data default="{tab: '{{RelationManager::$managers[0]->name}}'}">
        <div class="flex justify-center">
            <nav
                class="filament-tabs flex overflow-x-auto items-center p-1 space-x-1 rtl:space-x-reverse text-sm text-gray-600 bg-gray-500/5 rounded-xl dark:bg-gray-500/20">

                @foreach(RelationManager::$managers as $relation)

                    <button @click.prevent="data.tab = '{{$relation->name}}'"
                            aria-selected="" role="tab" type="button"

                            :class=
                                "{'rounded-lg whitespace-nowrap shadow bg-white text-primary-600': data.tab ==='{{$relation->name}}'}"
                            class="flex whitespace-nowrap items-center h-8 px-5 font-medium hover:text-black-900  focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-inset   dark:text-white dark:bg-primary-600">
                        {{__($relation->name)}}
                    </button>

                @endforeach
            </nav>

        </div>
        @foreach(RelationManager::$managers as $relation)

            <div v-show="data.tab === '{{$relation->name}}'" class="border bg-white shadow-sm rounded-lg py-4 px-4 ">
                <div class="">

                    @if(isset($relation))
                        <dev class="flex justify-end mb-6">
                            <Link {{$relation->showModal}} href="{{$relation->path}}create"
                                  class="filament-button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                                {{__('sync')}}
                            </Link>
                        </dev>
                        <x-splade-table :for="$relation->table" use="$relation" striped>

                            <x-splade-cell actions use="$relation">

                                <div class="flex justify-start">
                                    @if($relation->canShow && !is_null($relation->path))
                                        <Link href="{{$relation->path . $item->id }}" class="px-2 text-blue-500"
                                            {{$relation->showModal}}>
                                            <div class="flex justify-start space-x-2">
                                                <x-heroicon-s-eye class="h-4 w-4 ltr:mr-2 rtl:ml-2"/>
                                                <span>{{trans('tomato-admin::global.crud.view')}}</span>
                                            </div>
                                        </Link>
                                    @endif
                                    @if($relation->canEdit && !is_null($relation->path))

                                        <Link href="{{$relation->path . $item->id }}/edit" class="px-2 text-yellow-400"
                                            {{$relation->showModal}}>
                                            <div class="flex justify-start space-x-2">
                                                <x-heroicon-s-pencil class="h-4 w-4 ltr:mr-2 rtl:ml-2"/>
                                                <span>{{trans('tomato-admin::global.crud.edit')}}</span>
                                            </div>
                                        </Link>
                                    @endif

                                    @if($relation->canDelete && !is_null($relation->path))

                                        <Link href="{{$relation->path . $item->id }}"
                                              confirm="{{trans('tomato-admin::global.crud.delete-confirm')}}"
                                              confirm-text="{{trans('tomato-admin::global.crud.delete-confirm-text')}}"
                                              confirm-button="{{trans('tomato-admin::global.crud.delete-confirm-button')}}"
                                              cancel-button="{{trans('tomato-admin::global.crud.delete-confirm-cancel-button')}}"
                                              class="px-2 text-red-500"
                                              method="delete"

                                        >
                                            <div class="flex justify-start space-x-2">
                                                <x-heroicon-s-trash class="h-4 w-4 ltr:mr-2 rtl:ml-2"/>
                                                <span>{{trans('tomato-admin::global.crud.delete')}}</span>
                                            </div>
                                        </Link>
                                    @endif

                                </div>
                            </x-splade-cell>
                        </x-splade-table>
                    @else
                        <div class="relative text-center">
                            <div class="flex items-center justify-center">
                                <div
                                    class="flex flex-col items-center justify-center flex-1 p-6 mx-auto space-y-6 text-center bg-white filament-tables-empty-state dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div
                                        class="flex items-center justify-center w-16 h-16 rounded-full text-primary-500 bg-primary-50 dark:bg-gray-700">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>

                                    <div class="max-w-md space-y-1">
                                        <h2 class="text-xl font-bold tracking-tight filament-tables-empty-state-heading dark:text-white">
                                            {{ trans('tomato-admin::global.empty') }}
                                        </h2>

                                        <p
                                            class="text-sm font-medium text-gray-500 whitespace-normal filament-tables-empty-state-description dark:text-gray-400">

                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <hr class="my-4">

            </div>
        @endforeach

    </x-splade-data>

</div>
