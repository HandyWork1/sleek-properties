@props(['row'])

<x-button-view :href="route('enquiries.show', $row->id)" />