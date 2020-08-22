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
                <li>Time Slots <span class="text-sm font-thin">(coming soon)</span></li>
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
                    <br><br>
                    <span class="font-bold">Works for these types of events:</span>
                    <br>
                    Real Ops, Crossfire
                    <br><br>
                    <span class="font-bold">Available fields:</span>
                    <br>
                    Callsign, Departure and Arrival Airport, Departing Date and Time, Arrival Date and Time.

                    <div wire:click="setBookableType('flight')" class="btn btn-blue mt-4">Choose Flights Bookable Type</div>
                </div>
            </div>
            <div class="w-full mt-4">
                <a @click="showingType = 'time-slot'" class="btn btn-blue-secondary block">Time Slots</a>
                <div x-show="showingType == 'time-slot'" class="px-6 py-4 mt-4 rounded bg-white border-2 border-blue-200">
                    <div class="mb-4 bg-blue-300 rounded text-center text-gray-50">COMING SOON</div>
                    The time slots bookable type; handy for when you want to control flow.
                    <br><br>
                    Want to hold an event where you want bookings but not specifically tied to anything but a time-slot? Then this is the bookable type for your event!
                    <br><br>
                    You will be given the option to split up your event in time slots. For each of those time slots you will indicate how much traffic you want to assign to it! Thus an excellent way to keep your traffic flow more manageable!
                    <br><br>
                    <span class="font-bold">Works for these types of events:</span>
                    <br>
                    Friday Night Ops (FNO), Overload, Fly-ins
                </div>
            </div>
        </div>
    </div>
</div>
