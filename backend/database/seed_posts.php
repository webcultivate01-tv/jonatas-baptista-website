<?php
/**
 * One-time seed data for the `posts` table, sourced from the articles that
 * used to be hardcoded in blog-post.html. Used only by migrate.php.
 */

return [
    [
        'slug' => 'three-property-framework',
        'category_slug' => 'investment-strategy',
        'title' => 'The Three-Property Framework: How to Build a Real Estate Portfolio That Actually Works',
        'excerpt' => "Most investors buy properties reactively — something comes up, the numbers look acceptable, and they move forward. A portfolio built without a clear framework is harder to finance, harder to manage, and far harder to exit. Here's how to approach it intentionally.",
        'image' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=1400&q=80&auto=format&fit=crop',
        'tags' => 'Investment Strategy,Portfolio Building,Real Estate',
        'read_minutes' => 8,
        'published_at' => '2026-03-04 09:00:00',
        'body' => <<<HTML
            <p>Most investors buy properties reactively — something comes up, the numbers look acceptable, and they move forward. It feels productive. It feels like progress. But a portfolio assembled this way is almost always harder to finance, harder to manage, and far harder to exit than one built with intention from the start.</p>

            <h2>Why "One Deal at a Time" Breaks Down</h2>
            <p>Buying reactively works fine for a single property. The problem shows up at property two or three, when the lender starts asking questions your first deal never raised: how does this asset fit with what you already own? What's your debt-to-income trajectory? Is this diversification, or duplication?</p>
            <p>Without a framework, most investors discover the answer to those questions only after they've already signed. That's the expensive way to learn.</p>

            <h2>The Three-Property Framework</h2>
            <p>After advising hundreds of investors, I've found that portfolios which scale cleanly almost always follow the same underlying structure — three distinct roles, built in a deliberate sequence.</p>

            <h3>1. The Anchor Property</h3>
            <p>This is the foundation: a stable, well-located asset with predictable appreciation and low volatility. Its job isn't to generate excitement — it's to anchor your borrowing capacity and give every future lender a reason to trust your judgment.</p>

            <h3>2. The Cash-Flow Property</h3>
            <p>Once the anchor is in place, the second acquisition should be selected specifically for income. This is the property that funds your next move without requiring you to dip into savings or personal income — it's what keeps the portfolio self-sustaining.</p>

            <h3>3. The Growth Property</h3>
            <p>Only with an anchor and a cash-flow engine in place should you take on a higher-upside, higher-volatility asset. At this stage, you can absorb a slower stretch of appreciation because the rest of the portfolio is already carrying its weight.</p>

            <h2>Sequencing Matters More Than Speed</h2>
            <p>The order here isn't arbitrary. Investors who buy their growth property first — chasing the biggest potential return — are the ones who get stuck when the market cools, because they have no cash-flow asset to lean on and no anchor to reassure lenders.</p>

            <blockquote>"A portfolio built without a clear framework is harder to finance, harder to manage, and far harder to exit."</blockquote>

            <h2>Putting It Into Practice</h2>
            <p>Before your next acquisition, ask a simple question: what role is this property actually playing in my portfolio? If you can't answer that in one sentence, it's worth pausing before you sign anything.</p>
            <p>The investors who build lasting portfolios aren't the ones who move fastest — they're the ones who know exactly why each property is there.</p>
            HTML,
    ],
    [
        'slug' => 'evaluate-property-opportunity',
        'category_slug' => 'property-analysis',
        'title' => "How to Evaluate a Property Opportunity Before You Fall in Love With It",
        'excerpt' => "Emotional attachment is the silent killer of investment returns. This guide walks through the due diligence checklist Jonatas applies to every opportunity — separating the numbers that matter from the ones that distract.",
        'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1400&q=80&auto=format&fit=crop',
        'tags' => 'Property Analysis,Due Diligence,Decision-Making',
        'read_minutes' => 10,
        'published_at' => '2026-02-26 09:00:00',
        'body' => <<<HTML
            <p>Emotional attachment is the silent killer of investment returns. It doesn't announce itself — it shows up as a slightly generous valuation, a slightly optimistic rent projection, a willingness to overlook a structural issue because the kitchen "felt right." By the time you notice it, the deal is already signed.</p>

            <h2>Separate the Viewing From the Analysis</h2>
            <p>The single biggest improvement most investors can make is refusing to run the numbers while standing in the property. Walk through, take notes, take photos — then leave, and do the analysis somewhere the light and the staging can't influence your spreadsheet.</p>

            <h2>The Checklist That Actually Matters</h2>
            <h3>Cash Flow, Not Just Price</h3>
            <p>Price tells you what you're paying. It tells you nothing about what the asset will return. Every opportunity gets run through the same cash-flow model before price is even discussed — because a "great price" on a property with poor fundamentals is still a poor investment.</p>

            <h3>The Cost of Capital, Realistically</h3>
            <p>Too many projections use today's best-case financing terms. Build in a buffer. If the deal only works at the most favorable rate available, it doesn't really work.</p>

            <h3>Exit Liquidity</h3>
            <p>Before buying, ask who would want this property in five years — and how many of them there are. An asset with a narrow buyer pool is a harder asset to exit, regardless of how attractive the entry price looks today.</p>

            <h3>Structural and Legal Diligence</h3>
            <p>This is where deals quietly die, and where they should. A property with a clean structural report and clear title is worth paying a premium for; one without either is a discount that isn't actually a discount once you account for the risk.</p>

            <h2>The Questions That Filter Out Emotional Deals</h2>
            <ul>
                <li>Would I still buy this if it were in a neighborhood I felt nothing about?</li>
                <li>Am I adjusting my model to make the deal work, or does the deal work on its own?</li>
                <li>What specifically about this property is generating the return — and is that repeatable?</li>
            </ul>

            <blockquote>"This guide walks through the due diligence checklist applied to every opportunity — separating the numbers that matter from the ones that distract."</blockquote>

            <h2>The Discipline Pays for Itself</h2>
            <p>None of this is about being cold toward the process. It's about making sure the excitement of finding a good property doesn't quietly override the discipline of confirming it actually is one. The investors with the strongest portfolios aren't the ones with the best instincts — they're the ones who never let instinct skip the checklist.</p>
            HTML,
    ],
    [
        'slug' => 'five-mistakes-new-investors',
        'category_slug' => 'market-insights',
        'title' => "The Five Mistakes That Cost New Investors Their First Deal — And Their Confidence",
        'excerpt' => "Experience is an excellent teacher, but borrowed experience is even better. After hundreds of advisory sessions, these are the avoidable errors that appear consistently — and how to sidestep each one before it costs you.",
        'image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=1400&q=80&auto=format&fit=crop',
        'tags' => 'Market Insights,First-Time Investors,Lessons Learned',
        'read_minutes' => 7,
        'published_at' => '2026-02-18 09:00:00',
        'body' => <<<HTML
            <p>Experience is an excellent teacher, but borrowed experience is even better — especially when the tuition for the first-hand version is a failed deal. After hundreds of advisory sessions with new investors, the same five mistakes surface again and again.</p>

            <h2>1. Underestimating the True Cost of Ownership</h2>
            <p>New investors budget for the mortgage and forget almost everything else: maintenance reserves, vacancy periods, management fees, insurance increases. The property that looked profitable on paper quietly becomes break-even once the full cost picture is in view.</p>

            <h2>2. Anchoring to the Asking Price</h2>
            <p>The listed price shapes every negotiation that follows it, even when it has little to do with actual value. Walking in with your own independent valuation — before you see the seller's number — protects you from negotiating against a figure that was never grounded in fundamentals to begin with.</p>

            <h2>3. Skipping the "What If It Sits Empty" Scenario</h2>
            <p>Every model should be stress-tested against a vacancy period longer than you expect. If the deal only survives with the property rented 100% of the time, it isn't a deal — it's a bet.</p>

            <h2>4. Treating the First Deal as the Only Deal</h2>
            <p>First-time investors often pour every available resource into a single property, leaving no capacity to act if a better opportunity appears six months later. Keeping some flexibility in reserve is a strategy, not a hesitation.</p>

            <h2>5. Confusing Confidence With Conviction</h2>
            <p>Confidence says "I feel good about this." Conviction says "I can explain exactly why this works, in numbers, to someone who disagrees with me." New investors frequently have the first without the second — and it's the second that actually protects capital.</p>

            <blockquote>"These are the avoidable errors that appear consistently — and how to sidestep each one before it costs you."</blockquote>

            <h2>The Pattern Behind All Five</h2>
            <p>Every one of these mistakes comes from the same root cause: moving on emotion or urgency instead of a repeatable process. The good news is that none of them require more capital or more experience to avoid — just a framework, applied consistently, before the excitement of a deal takes over.</p>
            HTML,
    ],
    [
        'slug' => 'generational-wealth-real-estate',
        'category_slug' => 'wealth-building',
        'title' => 'Building Generational Wealth Through Real Estate: The Long Game Nobody Talks About',
        'excerpt' => "Short-term gains get the headlines. But the investors who quietly build lasting wealth operate with a completely different time horizon. This piece explores the compounding principles behind durable real estate wealth.",
        'image' => 'https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=1400&q=80&auto=format&fit=crop',
        'tags' => 'Wealth Building,Long-Term Strategy,Real Estate',
        'read_minutes' => 12,
        'published_at' => '2026-02-10 09:00:00',
        'body' => <<<HTML
            <p>Short-term gains get the headlines. The flip that doubled in eighteen months, the off-market deal that closed below value — these are the stories that travel. But the investors who quietly build lasting, generational wealth are almost never the ones telling them. They're operating on a completely different time horizon.</p>

            <h2>Wealth Is Built in Decades, Not Deals</h2>
            <p>A single great deal can change a year. A disciplined approach, held consistently for fifteen or twenty years, changes a family's trajectory. The investors who understand this stop optimizing for the next transaction and start optimizing for the compounding curve.</p>

            <h2>The Three Forces That Compound</h2>
            <h3>Debt Paydown</h3>
            <p>Every mortgage payment made by a tenant is equity quietly transferring to the owner. It's unremarkable month to month and transformative over a decade — the least exciting form of wealth building, and one of the most reliable.</p>

            <h3>Appreciation</h3>
            <p>Markets fluctuate in the short term but tend to trend upward over long horizons in well-chosen locations. The investor with a twenty-year view doesn't need to time the market — they need to be in the right market and stay there.</p>

            <h3>Cash Flow Reinvestment</h3>
            <p>Income that gets reinvested, rather than spent, is what turns a handful of properties into a portfolio. This is the step most new investors skip — and the one that separates a decent outcome from a generational one.</p>

            <h2>What "The Long Game" Actually Looks Like</h2>
            <p>It looks unglamorous. It looks like holding through a flat market instead of panic-selling. It looks like reinvesting a good year's cash flow instead of upgrading a lifestyle. It looks like buying the anchor property before the exciting one, every time.</p>

            <blockquote>"This piece explores the compounding principles behind durable real estate wealth — the ones nobody puts in a headline."</blockquote>

            <h2>Building for the Next Generation</h2>
            <p>The families who transfer real wealth across generations aren't the ones who got lucky on a single deal. They're the ones who built a system, stuck with it through uneventful years, and let time do the compounding no single transaction ever could. That's the long game — and it's still the most reliable one there is.</p>
            HTML,
    ],
    [
        'slug' => 'reading-the-market-without-noise',
        'category_slug' => 'market-insights',
        'title' => 'Reading the Market Without Getting Distracted by the Noise',
        'excerpt' => "Headlines are designed to create urgency. Market fundamentals move slowly and reward those who can separate signal from noise. Here's the framework Jonatas uses to interpret market data and make decisions with conviction.",
        'image' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=1400&q=80&auto=format&fit=crop',
        'tags' => 'Market Insights,Data-Driven Decisions,Strategy',
        'read_minutes' => 9,
        'published_at' => '2026-02-02 09:00:00',
        'body' => <<<HTML
            <p>Headlines are designed to create urgency — that's their job. Market fundamentals, on the other hand, move slowly and reward the investors who can tell the difference between a real shift and a news cycle.</p>

            <h2>Why Noise Feels Louder Than Signal</h2>
            <p>A dramatic headline about a market "correction" generates more attention than a quiet, steady trendline — even when the trendline is the thing that actually determines outcomes. Our brains are wired to react to novelty, not consistency, which is exactly backwards for investment decisions.</p>

            <h2>The Framework: Three Questions Before Any Reaction</h2>

            <h3>1. Is This Local or National?</h3>
            <p>National headlines rarely reflect what's happening in a specific submarket. Before reacting to any market news, the first question is always whether it applies to the actual asset class and location in question — or whether it's simply a national average masking very different local realities.</p>

            <h3>2. Is This a Trend or a Data Point?</h3>
            <p>One month of data is a data point. Six consecutive months in the same direction is a trend. Treating the former like the latter is how investors end up making reactive decisions based on statistical noise.</p>

            <h3>3. What Would Have to Be True for This to Matter to Me Specifically?</h3>
            <p>Most market news is irrelevant to any individual investor's specific position. This question filters out headlines that are technically accurate but practically meaningless for the decision actually in front of you.</p>

            <h2>Building a Personal Dashboard</h2>
            <p>Rather than consuming market commentary as it's published, the more reliable approach is tracking a small set of metrics relevant to your specific markets — inventory levels, days on market, rent growth — on your own schedule. This turns market reading from a reactive habit into a deliberate practice.</p>

            <blockquote>"Market fundamentals move slowly and reward those who can separate signal from noise."</blockquote>

            <h2>Conviction Over Reaction</h2>
            <p>The goal isn't to ignore the market — it's to read it on your own terms, at your own pace, filtered through a framework instead of a news feed. That's what allows for decisions made with conviction, instead of decisions made in response to whatever happened to be trending that week.</p>
            HTML,
    ],
    [
        'slug' => 'investors-decision-framework',
        'category_slug' => 'decision-making',
        'title' => "The Investor's Decision Framework: How to Choose Confidently When the Stakes Are High",
        'excerpt' => "Indecision is expensive. So is the wrong decision made too quickly. This article breaks down the structured thinking process Jonatas guides clients through before any significant investment commitment is made.",
        'image' => 'https://images.unsplash.com/photo-1600880292089-90a7e086ee0c?w=1400&q=80&auto=format&fit=crop',
        'tags' => 'Decision-Making,Strategy,Investment Framework',
        'read_minutes' => 11,
        'published_at' => '2026-01-26 09:00:00',
        'body' => <<<HTML
            <p>Indecision is expensive — every week spent deliberating on a good opportunity is a week it's available to someone else. But the wrong decision made too quickly is even more expensive. The goal isn't speed or caution on their own; it's a process that produces both at once.</p>

            <h2>Why Most Decision-Making Breaks Down Under Pressure</h2>
            <p>When the stakes rise, most people default to one of two failure modes: they freeze, running the same numbers over and over without new information, or they rush, mistaking urgency for progress. Neither is a strategy — both are the absence of one.</p>

            <h2>The Structured Process</h2>

            <h3>Step 1: Define the Decision, Not Just the Deal</h3>
            <p>Before evaluating a specific opportunity, get clear on what decision is actually being made. Is this "should I buy this property," or is it "should I move into this asset class at all"? Conflating the two leads to over-analyzing a single deal instead of answering the real question underneath it.</p>

            <h3>Step 2: Set the Threshold Before You Look at the Numbers</h3>
            <p>Decide in advance what would make this a yes — target return, risk tolerance, timeline — before the specific opportunity has a chance to bias the answer. This is the single most effective way to prevent a good pitch from overriding good judgment.</p>

            <h3>Step 3: Identify What Would Change Your Mind</h3>
            <p>A strong decision isn't just "yes" or "no" — it's "yes, unless X" or "no, unless Y." Naming the specific condition that would flip your decision turns a vague feeling into a testable position.</p>

            <h3>Step 4: Set a Decision Deadline</h3>
            <p>Open-ended deliberation is how good opportunities quietly expire. Give every decision a hard date, and treat that date as seriously as the decision itself.</p>

            <blockquote>"This article breaks down the structured thinking process guided through before any significant investment commitment is made."</blockquote>

            <h2>What Confidence Actually Looks Like</h2>
            <p>Confidence at high stakes doesn't come from certainty — nobody has that. It comes from knowing you followed a process robust enough to trust, regardless of the outcome. That's what separates a confident decision from a lucky one, and it's the only kind of confidence that holds up the next time the stakes are just as high.</p>
            HTML,
    ],
];
