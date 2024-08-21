<?php


use App\Http\Controllers\DownloadFilesController;
use Illuminate\Support\Facades\Route;
use MailchimpMarketing\ApiClient;

Route::get('download/{file}', DownloadFilesController::class)->name('download-files');

// Route::get('tmp', function () {
//     $mailchimp = new ApiClient();
//
//     $mailchimp->setConfig([
//         'apiKey' => env('MAILCHIMP_API_KEY'),
//         'server' => env('MAILCHIMP_SERVER_PREFIX'),
//     ]);
//
//     // $mailchimp->campaigns->send();
//
//     // $mailchimp->lists->addListMember(
//     //     config('hugger.MALCHIMP_LIST'), [
//     //     'email_address' => 'jaosorio1013@gmail.com',
//     //     'status' => 'transactional'
//     // ], true
//     // );
//
//     // // $mailchimp->lists->updateListMemberTags(config('hugger.MALCHIMP_LIST'), '86d0a210e596445d7d8d9a38f109fca7');
//     //
//     // // dd(
//     // //     $mailchimp->lists->getListMemberTags(
//     // //         config('hugger.MALCHIMP_LIST'),
//     // //         '86d0a210e596445d7d8d9a38f109fca7'
//     // //     )->tags[0]->
//     // // );
//     //
//     // // $response = $mailchimp->campaigns->list();
//     // // $response = $mailchimp->campaigns->list();
//     //
//     // $email = 'drubio@usil.edu.pe';
//     // $mailchimpUser = $mailchimp->searchMembers->search($email);
//     //
//     // dd(
//     //     $mailchimpUser->exact_matches->members[0]->id,
//     //     $mailchimpUser->exact_matches->members[0]->unique_email_id
//     // );
//     //
//     //
//     // // dd($mailchimp->lists->getAllLists());
//     // $tags = $mailchimp->lists->tagSearch(
//     //     config('hugger.MALCHIMP_LIST'), 'CRM'
//     // );
//     // // id
//     // // name
//     //
//     //
//     // dd($tags->tags);
//     //
//     // foreach ($response->campaigns as $item) {
//     //     dd($item);
//     //
//     //     $campaign = MailchimpCampaign::query()->where('mailchimp_id', $item->web_id)->first();
//     //     if (!$campaign) {
//     //         $campaign = MailchimpCampaign::query()->create([
//     //             'mailchimp_id' => $item->web_id,
//     //             'name' => $item->settings->title,
//     //             'subject' => $item->settings->subject_line,
//     //         ]);
//     //     }
//     //
//     //     $campaign->update([
//     //         'name' => $item->settings->title,
//     //         'subject' => $item->settings->subject_line,
//     //         'created_at' => Carbon::parse($item->create_time),
//     //     ]);
//     // }
// });
