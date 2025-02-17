<h1 class="h2">{{ __('emails.exercise_correction.body.greeting', ['name' => $gradeable->student->first_name]) }}</h1>

<p>{{ __('emails.exercise_correction.body.message', ['title' => $gradeable->assessment->exercise->title]) }}</p>

<ul>
  <li>{{ __('emails.exercise_correction.body.value', ['value' => $gradeable->gradable->value]) }}</li>
  <li>{{ __('emails.exercise_correction.body.comment', ['comment' => $gradeable->gradable->comment]) }}</li>
</ul>

<p>
  <a href="{{ env('APP_URL') }}">{{ __('emails.exercise_correction.body.link') }}</a>
</p>
