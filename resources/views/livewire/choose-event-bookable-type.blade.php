<div>
    <div x-data="{showInformation: true}">
        <div x-show="showInformation" class="px-6 py-4 my-4 font-light rounded bg-white border-2 border-blue-200">

            <div @click="showInformation = false" class="btn btn-blue-secondary mb-4 mx-auto w-1/3">Close</div>

            Awesome! We have an event setup, now let's figure out what type of event you want this to be.
            <br>
            Based on the event type you'll determine what type of booking system you will have.
            <br><br>
            <span class="font-bold">The Event Bookable Types:</span>
            <ul class="ml-4">
                <li>Flights</li>
                <li>Time Slots</li>
            </ul>
            <br>
            Click on the type button for more information about the type.
        </div>
        <div x-data="{showingType: 'none'}" @click.away="showingType = 'none'" class="mt-6 flex flex-wrap">
            <div class="w-full">
                <a @click="showingType = 'flight'" class="btn btn-blue-secondary block">Flights</a>
                <div x-show="showingType == 'flight'" class="px-6 py-4 mt-4 rounded bg-white border-2 border-blue-200">
                    The flights bookable type is the classic type.
                    <br><br>
                    If your event requires the booking of specific defined flights from one point to another for specific dates and times, then this is the booking type for your event!.

                    <div wire:click="setBookableType('{{ \App\Models\BookableFlight::TYPE }}')" class="btn btn-blue mt-4">Choose Flights Bookable Type</div>
                </div>
            </div>
            <div class="w-full mt-4">
                <a @click="showingType = 'time-slot'" class="btn btn-blue-secondary block">Time Slots</a>
                <div x-show="showingType == 'time-slot'" class="px-6 py-4 mt-4 rounded bg-white border-2 border-blue-200">
                    <div class="mb-4 mx-auto bg-green-400 rounded text-center text-gray-50 md:w-1/2 lg:w-1/4">NEW</div>
                    The time slots bookable type; handy for when you want to control flow.
                    <br><br>
                    Want to hold an event where you want bookings but not specifically tied to anything but a time-slot? Then this is the bookable type for your event!
                    <br><br>
                    You will be given the option to split up your event in time slots. For each of those time slots you will indicate how much traffic you want to assign to it! Thus an excellent way to keep your traffic flow more manageable!

                    <div wire:click="setBookableType('{{ \App\Models\BookableTimeSlot::TYPE }}')" class="btn btn-blue mt-4">Choose Time Slot Type</div>
                </div>
            </div>
        </div>
    </div>
</div>
