# n top words from string
sentence = "Hello, this is Andre DeTienne, this is Lakshmi, and this is DongInn Kim. Nice to see you. I hope that you enjoy our interview questions."
sentence = sentence.replace(".", "")
sentence = sentence.replace(",", "")

countsByWord = {}	# does NOT work as they are PKs -> Java equivalent to countsByWord.put("key", "value") is countsByWord["key"] = "value"

words = sentence.split() #make into dicionary

# loop over all, loop over just the uniques
for word in words:
	
	if word in countsByWord:
		countsByWord[word] = countsByWord[word] + 1
	else:
		countsByWord[word] = 1
        
wordcounts = []

for word in countsByWord:			
	count = countsByWord[word]
	wordcounts.append((count, word))
        
#change order to prep for n input

wordcounts.sort(reverse=True)

# get users number input

n = int(input("Enter in a number from 1 to 25: "))

# Just grab the last n items 
topitems = wordcounts[:n]


for count, word in topitems:
	print(word)			

