<?php

namespace Ecommvu\Marketing\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Ecommvu\Marketing\Repositories\EventRepository;
use Ecommvu\Marketing\Repositories\CampaignRepository;
use Ecommvu\Marketing\Repositories\TemplateRepository;
use Ecommvu\Marketing\Mail\NewsletterMail;

class Campaign
{
    /**
     * EventRepository object
     *
     * @var \Ecommvu\Marketing\Repositories\EventRepository
     */
    protected $eventRepository;

    /**
     * CampaignRepository object
     *
     * @var \Ecommvu\Marketing\Repositories\CampaignRepository
     */
    protected $campaignRepository;

    /**
     * TemplateRepository object
     *
     * @var \Ecommvu\Marketing\Repositories\TemplateRepository
     */
    protected $templateRepository;

    /**
     * Create a new helper instance.
     *
     * @param  \Ecommvu\Marketing\Repositories\EventRepository  $eventRepository
     * @param  \Ecommvu\Marketing\Repositories\CampaignRepository  $campaignRepository
     * @param  \Ecommvu\Marketing\Repositories\TemplateRepository  $templateRepository
     *
     * @return void
     */
    public function __construct(
        EventRepository $eventRepository,
        CampaignRepository $campaignRepository,
        CampaignRepository $templateRepository
    )
    {
        $this->eventRepository = $eventRepository;

        $this->campaignRepository = $campaignRepository;

        $this->templateRepository = $templateRepository;
    }

    /**
     * @return void
     */
    public function process(): void
    {
        $campaigns = $this->campaignRepository->getModel()
            ->leftJoin('marketing_events', 'marketing_campaigns.marketing_event_id', 'marketing_events.id')
            ->leftJoin('marketing_templates', 'marketing_campaigns.marketing_template_id', 'marketing_templates.id')
            ->select('marketing_campaigns.*')
            ->where('marketing_campaigns.status', 1)
            ->where('marketing_templates.status', 'active')
            ->where(function ($query) {
                $query->where('marketing_events.date', Carbon::now()->format('Y-m-d'))
                    ->orWhereNull('marketing_events.date');
            })
            ->get();

        foreach ($campaigns as $campaign) {
            if ($campaign->event->name == 'Birthday') {
                $emails = $this->getBirthdayEmails($campaign);
            } else {
                $emails = $this->getEmailAddresses($campaign);
            }

            foreach ($emails as $email) {
                Mail::queue(new NewsletterMail($email, $campaign));
            }
        }
    }

    /**
     * Build the message.
     *
     * @param  \Ecommvu\Marketing\Contracts\Campaign  $campaign
     * @return array
     */
    public function getEmailAddresses($campaign)
    {
        $emails = [];

        $customerGroupEmails = $campaign->customer_group->customers()->where('subscribed_to_news_letter', 1)->get('email');

        foreach ($customerGroupEmails as $row) {
            $emails[] = $row->email;
        }

        return array_unique($emails);
    }

    /**
     * Return customer's emails who has a birthday today
     *
     * @param  \Ecommvu\Marketing\Contracts\Campaign  $campaign
     * @return array
     */
    public function getBirthdayEmails($campaign)
    {
        $customerGroupEmails = $campaign->customer_group->customers()
            ->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = ?', [Carbon::now()->format('m-d')])
            ->where('subscribed_to_news_letter', 1)
            ->get('email');

        $emails = [];

        foreach ($customerGroupEmails as $row) {
            $emails[] = $row->email;
        }

        return $emails;
    }
}