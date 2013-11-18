var TimelineModel = {
    data: {},
    
    getEvents: function(period) {
        if (period) {
            
        } else {
            var temp = {};
            
        }
    },
    
    getPeriods: function() {
        that = this;
        $.get("api.php?query=periods", function(data) {
            that.data = data;
            console.log(that);
        });
        
    }
    
}