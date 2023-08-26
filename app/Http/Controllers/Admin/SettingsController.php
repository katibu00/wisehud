<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Charges;
use App\Models\MonnifyKey;
use App\Models\OpenAIKey;
use App\Models\PopUp;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function openaiKeys()
    {
        $openAIKey = OpenAIKey::first();
        return view('admin.settings.openai_key', compact('openAIKey'));
    }
    

    public function monnifyKeys()
    {
        $monnifyKeys = MonnifyKey::first();
        return view('admin.settings.monnify_key',compact('monnifyKeys'));
    }
    public function charges()
    {
        $charges = Charges::first();
        return view('admin.settings.charges', compact('charges'));
    }
    public function popup()
    {
        $popUp = PopUp::first();
        return view('admin.settings.popup', compact('popUp'));
    }


    public function savePopup(Request $request)
    {
        $request->validate([
            'notificationSwitch' => 'nullable|in:on,off',
            'notificationBody' => 'required_if:notificationSwitch,on',
        ]);
    
        $popUp = PopUp::first();
        if (!$popUp) {
            $popUp = new PopUp();
        }
    
        // Set the value of switch as "off" if it is not sent in the request
        $popUp->switch = $request->has('notificationSwitch') ? $request->input('notificationSwitch') : 'off';
        $popUp->body = $request->input('notificationBody');
        $popUp->save();
    
        return redirect()->back()->with('success', 'Pop up notification settings updated successfully.');
    }

    public function saveOpenai(Request $request)
    {
        $validatedData = $request->validate([
            'api_key' => 'required|string',
        ]);

        $existingKey = OpenAIKey::first();

        if ($existingKey) {
            $existingKey->update([
                'key' => $validatedData['api_key'],
            ]);

            return redirect()->back()->with('success', 'API key updated successfully');
        } else {
            $openAIKey = new OpenAIKey();
            $openAIKey->key = $validatedData['api_key'];
            $openAIKey->save();
            return redirect()->back()->with('success', 'API key saved successfully');
        }
    }


    public function saveMonnify(Request $request)
    {
        $validatedData = $request->validate([
            'public_key' => 'required|string',
            'secret_key' => 'required|string',
            'contract_code' => 'required|string',
        ]);

        $monnifyKeys = MonnifyKey::first();

        if ($monnifyKeys) {
            $monnifyKeys->update($validatedData);
        } else {
            $monnifyKeys = MonnifyKey::create($validatedData);
        }

        return redirect()->back()->with('success', 'Monnify API keys saved successfully');
    }

    public function saveCharges(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'charges_per_chat' => 'required|numeric',
        'funding_charges_amount' => 'required|numeric',
        'welcome_bonus' => 'required|numeric',
        'referral_bonus' => 'required|numeric',
        'whatsapp_group_link' => 'nullable|string:255',
        'funding_charges_description' => 'nullable|string:255',
    ]);

    $charges = Charges::first();

    if ($charges) {
        // Update the existing record
        $charges->update($validatedData);
    } else {
        // Create a new record
        $charges = Charges::create($validatedData);
    }

    // Redirect or return a response
    // You can modify this part based on your requirements
    return redirect()->back()->with('success', 'Charges configuration saved successfully');
}

}
